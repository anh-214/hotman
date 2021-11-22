@extends('backend.layouts.app')

@section('title')
    Chi tiết khuyến mãi
@endsection
@push('css')
    <style>
        .hint-text{
            width: 5em; /* the element needs a fixed width (in px, em, %, etc) */
            overflow: hidden; /* make sure it hides the content that overflows */
            white-space: nowrap; /* don't break the line */
            text-overflow: ellipsis; /* give the beautiful '...' effect */
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-2" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Chi tiết khuyến mại</h6>
                    <a href="{{url('admin/promotions')}}">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body pt-0 pb-2 mx-2">
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;"> 
                    <h6>{{$promotion->name}} - Giảm giá: {{$promotion->discount}}% - Hiển thị trên trang chủ: {{($promotion->show == '1') ? 'Có' : 'Không'}}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-4 mx-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Initial_price</th>
                                    {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Update_at</th> --}}
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Action</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotion->types as $type)
                                    <tr>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->id}}"> {{$type->id}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->name}}"> {{$type->name}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{number_format($type->price)}}đ"> {{number_format($type->price)}}đ</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{number_format($type->initial_price)}}đ"> {{number_format($type->initial_price)}}đ</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" href="{{url('admin/types/'.$type->id)}}" class="text-secondary font-weight-bold text-xs deleteTypeFromPromotion">
                                                <span class="badge badge-sm bg-gradient-primary">Xem loại sản phẩm</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs deleteTypeFromPromotion"data-type={{$type->id}}>
                                                <span class="badge badge-sm bg-gradient-danger">Xóa khỏi khuyến mãi</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 {{-- modal delete --}}
<div class="modal fade" id="confirmDeletePromotionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa khuyến mại</h5>
            </div>
            <div class="modal-body">
            <form>
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa khuyến mại</h6></label>
                <input type="text" class="form-control" name="confirmPasswordDelete">
                <div class="invalid-feedback" id="errorPasswordDelete">
                </div>
                <input type="hidden" class="form-control" name="deletePromotionId" >
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="buttonConfirmDeletePromotion">Xác nhận</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

{{-- modal update --}}
<div class="modal fade" id="updatePromotion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập nhật khuyến mại</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateForm" action="{{url('admin/promotions/update')}}">
                    @csrf
                    <input type="hidden" name="updateId">
                    <div class="mb-3">
                        <label for="updateName" class="col-form-label"><h6>Tên:</h6></label>
                        <input type="text" class="form-control" id="updateName" name="updateName">
                        <div class="invalid-feedback" id="errorUpdateName">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="updateDiscount" class="col-form-label"><h6>Giảm giá (%):</h6></label>
                        <input type="number" class="form-control" id="updateDiscount" name="updateDiscount">
                        <div class="invalid-feedback" id="errorupdateDiscount">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="updateShow" class="col-form-label"><h6>Hiển thị:</h6></label>
                        <select class="form-control" name="updateShow" id="updateShow">
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    <button type="button" class="btn bg-gradient-success" id="buttonUpdate">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm chương trình khuyến mãi</h5>
            </div>
            <div class="modal-body">
            <form method="POST" id="createForm" action="{{url('admin/promotions/create')}}">
                @csrf
                <div class="mb-3">
                    <label for="createName" class="col-form-label"><h6>Tên:</h6></label>
                    <input type="text" class="form-control" id="createName" name="createName">
                    <div class="invalid-feedback" id="errorCreateName">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="createDiscount" class="col-form-label"><h6>Giảm giá (%):</h6></label>
                    <input type="number" class="form-control" id="createDiscount" name="createDiscount">
                    <div class="invalid-feedback" id="errorCreateDiscount">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="createShow" class="col-form-label"><h6>Hiển thị:</h6></label>
                    <select class="form-control" name="createShow" id="createShow">
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-success" id="buttonCreate">Tạo</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
    <style>
        .modal-footer{
            border-top: 0px;
            padding-bottom: 0px
        }
        .modal-body{
            padding-bottom: 0px

        }
    </style>
@endpush
@push('js')
{{-- delete promotion modal boostrap --}}
<script>
    $(document).ready(function(){
        $('#confirmDeletePromotionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var promotion = button.data('promotion')
        var modal = $(this)
        modal.find('input[name=deletePromotionId]').val(promotion)
        });

        $("#buttonConfirmDeletePromotion").click(function(){
            $id = $('input[name=deletePromotionId]').val();
            $password = $('input[name=confirmPasswordDelete]')
            if ($password.val() == ''){
                $password.addClass('is-invalid');
                $("#errorPasswordDelete").text('Vui lòng không để trống trường này')
                
            } else {
                $password.removeClass('is-invalid');
                $("#errorPasswordDelete").text('')
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/promotions/delete",
                    data: {"_token": "{{ csrf_token() }}", 'id': $id, 'password':$password.val()},
                    success: function(data){
                        window.location.reload()                    
                    }
                });
            }
        })
    });
</script>

{{-- delete type from promotion --}}
<script>
    $(document).ready(function(){
        $(".deleteTypeFromPromotion").click(function(){
            $id = $(this).attr('data-type');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/admin/promotions/deletetype",
                data: {"_token": "{{ csrf_token() }}", 'id': $id},
                success: function(data){
                    window.location.reload()                    
                }
            });
        })
    });
</script>

<script>
    $(document).ready(function(){
        $('#updatePromotion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var name = button.data('name') // Extract info from data-* attributes
        var id = button.data('id')
        var discount = button.data('discount')
        var show = button.data('show')

        if ( show == '1') {
            $(this).find('option[value=1]').attr('selected','selected')
        } else {
            $(this).find('option[value=0]').attr('selected','selected')
        }
        
        var modal = $(this)
        modal.find('#updateName').val(name)
        modal.find('#updateDiscount').val(discount)
        modal.find('input[name=updateId]').val(id)
        });
        $("#buttonUpdate").click(function(){
            $count = 0
            if ($("#updateName").val() == ''){
                $("#updateName").addClass('is-invalid');
                $("#errorUpdateName").text('Vui lòng không để trống trường này')
            } else {
                $("#updateName").removeClass('is-invalid');
                $("#errorUpdateName").text('')
                $count += 1
            }
            if ($("#updateDiscount").val() == ''){
                $("#updateDiscount").addClass('is-invalid');
                $("#errorUpdateDiscount").text('Vui lòng không để trống trường này')
            } else {
                $("#updateDiscount").removeClass('is-invalid');
                $("#errorUpdateDiscount").text('')
                $count += 1
            }
            if ($count ==2 ){
                $('#updateForm').submit()
            }
        })
    });

</script>

{{-- create promotion modal  --}}
<script>
    $(document).ready(function(){
        $("#buttonCreate").click(function(){
            let $checkName = false
            let $checkDiscount = false
            if ($("#createName").val() == ''){
                $("#createName").addClass('is-invalid');
                $("#errorCreateName").text('Vui lòng không để trống trường này')
                $checkName = false
            } else {
                $("#createName").removeClass('is-invalid');
                $("#errorCreateName").text('')
                $checkName = true
            }
            if ($("#createDiscount").val() == ''){
                $("#createDiscount").addClass('is-invalid');
                $("#errorCreateDiscount").text('Vui lòng không để trống trường này')
                $checkDiscount = false
            } else {
                $("#createDiscount").removeClass('is-invalid');
                $("#errorCreateDiscount").text('')
                $checkDiscount = true
            }
            if ($checkName == true && $checkDiscount == true){
                $("#createForm").submit();
            }
        })
    });

</script>
@endpush