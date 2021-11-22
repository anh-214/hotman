@extends('backend.layouts.app')

@section('title')
    Quản lí loại sản phẩm
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí loại sản phẩm</h6>
                    <div>
                        <a type="button" class="text-secondary font-weight-bold text-xl" href="{{url('admin/types/create')}}">
                            <span class="badge badge-sm bg-gradient-success">Thêm</span>
                        </a>
                        <a type="button" class="text-secondary font-weight-bold text-xl" id="deleteMutiple" >
                            <span class="badge badge-sm bg-gradient-danger">Xóa số lượng lớn</span>
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-1">
                            <thead>
                                <tr>
                                    <th class="px-4">
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="selectAll">
                                            <label for="selectAll"></label>
                                        </span>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Tên loại sản phẩm</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Giá bán ra</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Giá gốc</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hình ảnh</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-0">Thuộc sản phẩm</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-0">Khuyến mại</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hành động</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type )
                                    <tr>
                                        <td class="px-4">
                                            <span class="custom-checkbox">
                                                <input type="checkbox" class="checkbox" name="checkbox[]" value="{{$type->id}}">
                                                <label></label>
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->id}}"> {{$type->id}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->name}}"> {{$type->name}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 text-center">{{number_format($type->price)}}đ</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 text-center">{{number_format($type->initial_price)}}đ</p>
                                        </td>
                                        <td>
                                            <p type="button" class="text-center text-xs font-weight-bold mb-0 text-center showImages" data-id="{{$type->id}}">                                              
                                                    Xem
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 text-center hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->product_id.' - '.$type->product->name}}">
                                                <a href="{{url('admin/products/?id='.$type->product_id)}}" type="button" class="text-secondary">
                                                    {{$type->product->name}}
                                                </a>
                                            </p>                            
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 text-center hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="@php echo isset($type->promotion->name) ? $type->promotion->name : 'Không' @endphp">
                                                @isset($type->promotion->name)
                                                <a href="{{url('admin/promotions/'.$type->promotion->id)}}">
                                                    <span>{{$type->promotion->name}}</span>
                                                </a>
                                                @else
                                                    <span>Không</span>
                                                @endisset
                                            </p>                            
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('admin/types/'.$type->id)}}">
                                                <span class="badge badge-sm bg-gradient-primary">Xem chi tiết</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('admin/types/'.$type->id.'/update')}}">
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-name="{{$type->name}}" data-id="{{$type->id}}" >
                                                <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">{{$types->links('vendor.pagination.bootstrap-4')}}</div>
        </div>
    </div>
</div>

{{-- show image product modal --}}
<div class="modal fade p-5" id="showImagesModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ảnh sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                    </div>
                    <div class="carousel-inner">    
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal delete --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa loại sản phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST">
                @csrf
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa loại sản phẩm: </h6><span id="confirmCategory"></span></label>
                <input type="text" class="form-control" name="confirmPasswordDelete">
                <div class="invalid-feedback" id="errorPasswordDelete">
                </div>
                <input type="hidden" class="form-control" name="deleteId" >
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="buttonConfirmDelete">Xác nhận</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

{{-- modal delete multiple --}}
<div class="modal fade" id="confirmDeleteMutipleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa sản phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST">
                @csrf
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa các loại sản phẩm đã chọn</h6></label>
                <input type="text" class="form-control" name="confirmPasswordDeleteMutiple">
                <div class="invalid-feedback" id="errorPasswordDeleteMutiple">
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="buttonConfirmDeleteMutiple">Xác nhận</button>
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
{{--  delete mutiple --}}
<script>
    $(document).ready(function(){
        $("#buttonConfirmDeleteMutiple").click(function(){
            if ($("input[name=confirmPasswordDeleteMutiple]").val() == ''){
                $("input[name=confirmPasswordDeleteMutiple]").addClass('is-invalid');
                $("#errorPasswordDeleteMutiple").text('Vui lòng nhập mật khẩu của bạn')
            } else {
                $("input[name=confirmPasswordDeleteMutiple]").removeClass('is-invalid');
                $("#errorPasswordDeleteMutiple").text('')
                let select = [];
                $(':checkbox:checked').each(function(){
                    if ($(this).val() != 'on'){
                        select.push($(this).val());
                    }
                });
                let obj = Object.assign({}, select);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/types/mutipledelete",
                    data: {"_token": "{{ csrf_token() }}", 'mutipleId' : obj, 'confirmPassword': $("input[name=confirmPasswordDeleteMutiple]").val()},
                    success: function(data){
                        window.location.reload()
                    }
                });
            }
        })
        $("#deleteMutiple").click(function(){
            if ($('.checkbox:checked').length == 0) {
                $("#textNotificationDeleteMutipleModal").text("Vui lòng chọn ít nhất 1 records");
                $("#notificationDeleteMutipleModal").modal('show')
            } else {
                $("#confirmDeleteMutipleModal").modal('show')
            }
	    })
        let checkbox = $('table tbody input[type="checkbox"]');
        $("#selectAll").click(function(){
            if(this.checked){
                checkbox.each(function(){
                    this.checked = true;                        
                });
            } else{
                checkbox.each(function(){
                    this.checked = false;                        
                });
            } 
        });
        checkbox.click(function(){
            if(!this.checked){
                $("#selectAll").prop("checked", false);
            }
	    });
    });
</script>

{{-- delete --}}
<script>
    $(document).ready(function(){
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var name = button.data('name')
            var id = button.data('id')
            
            var modal = $(this)
            modal.find('#confirmCategory').text(name)
            modal.find('input[name=deleteId]').val(id)
        });
        $("#buttonConfirmDelete").click(function(){
            if ($("input[name=confirmPasswordDelete]").val() == ''){
                $("input[name=confirmPasswordDelete]").addClass('is-invalid');
                $("#errorPasswordDelete").text('Vui lòng nhập mật khẩu của bạn')
            } else {
                $("input[name=confirmPasswordDelete]").removeClass('is-invalid');
                $("#errorPasswordDelete").text('')
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/types/"+$("input[name=deleteId]").val()+"/delete",
                    data: {"_token": "{{ csrf_token() }}", 'confirmPassword': $("input[name=confirmPasswordDelete]").val()},
                    success: function(data){
                        window.location.reload()
                    }
                });
            }
        })
    });
</script>
{{-- data for show images --}}
<script>
    $(document).ready(function(){
        $modal = $('#showImagesModal')
        $(".showImages").click(function(){
            $id = $(this).attr('data-id')
            // console.log($id);
            deleteImages('showImagesModal','.carousel-inner')
            deleteImages('showImagesModal','.carousel-indicators')
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/types/getImages",
                    data: {"_token": "{{ csrf_token() }}", 'type_id': $id},
                    success: function(data){
                        let $count = 0;
                        data.forEach(link => {   
                            addImages(link,'.carousel-inner',$count)
                            addIndicator('.carousel-indicators',$count)
                            $count += 1;
                        });
                    }
                });
            $modal.modal('show');
        })
        function deleteImages(modal_id,self_selector){
            $modal = $("#"+modal_id)
            $modal.on('hide.bs.modal',function(){
                $(self_selector).html("")
            });
        }
        function addImages(link,self_selector,count){
            if (count == 0){
                $(self_selector).append('<div class="carousel-item active"><img class="d-block w-100" src="'+link+'" ></div>')
            } else {
                $(self_selector).append('<div class="carousel-item"><img class="d-block w-100" src="'+link+'" ></div>')
            }
        }
        function addIndicator(self_selector,count){
            if (count == 0){
                $(self_selector).append('<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'+count+'" class="active" aria-current="true" aria-label="Slide '+(count+1)+'"></button>')
            } else {
                $(self_selector).append('  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'+count+'" aria-label="Slide '+(count+1)+'"></button>')
            }
        }
    });
</script>
@endpush