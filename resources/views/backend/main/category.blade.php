@extends('backend.layouts.app')

@section('title')
    Quản lí thể loại
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí thể loại</h6>
                    <div>
                        @isset($categories)
                            <a type="button" class="text-secondary font-weight-bold text-xl" >
                                <span class="badge badge-sm bg-gradient-success" data-bs-toggle="modal" data-bs-target="#createModal">Thêm</span>
                            </a>
                            <a type="button" class="text-secondary font-weight-bold text-xl" id="deleteMutiple" >
                                <span class="badge badge-sm bg-gradient-danger">Xóa số lượng lớn</span>
                            </a>
                        @endisset
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-4 mx-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    @isset($categories)
                                    <th class="px-4">
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="selectAll">
                                            <label for="selectAll"></label>
                                        </span>
                                    </th>
                                    @endisset
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Tên thể loại</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Mô tả</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thời gian tạo</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thời gian cập nhật</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hành động</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                {{-- view category --}}
                                @isset($category)
                                    <tr>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$category->id}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$category->name}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$category->desc}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$category->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$category->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('/admin/products?category_id='.$category->id)}}">
                                                <span class="badge badge-sm bg-gradient-primary">Tất cả sản phẩm</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="{{$category->name}}" data-desc="{{$category->desc}}" data-id="{{$category->id}}" >
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-name="{{$category->name}}" data-id="{{$category->id}}" >
                                                <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endisset

                                @isset($categories)
                                    @foreach ($categories as $category )
                                                <tr>
                                                    <td class="px-4">
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" class="checkbox" name="checkbox[]" value="{{$category->id}}">
                                                            <label></label>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p class="text-center text-xs font-weight-bold mb-0"> {{$category->id}}</p>
                                                    </td>
                                                    <td class="w-5">
                                                        <p class="text-center text-xs font-weight-bold mb-0"> {{$category->name}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center text-xs font-weight-bold mb-0"> {{$category->desc}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center text-xs font-weight-bold mb-0"> {{$category->created_at}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center text-xs font-weight-bold mb-0"> {{$category->updated_at}}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('/admin/products?category_id='.$category->id)}}">
                                                            <span class="badge badge-sm bg-gradient-primary">Tất cả sản phẩm</span>
                                                        </a>
                                                        <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="{{$category->name}}" data-desc="{{$category->desc}}" data-id="{{$category->id}}" >
                                                            <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                                        </a>
                                                        <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-name="{{$category->name}}" data-id="{{$category->id}}" >
                                                            <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                    @endforeach
                                @endisset                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @isset($categories)
                <div class="d-flex justify-content-center">{{$categories->links('vendor.pagination.bootstrap-4')}}</div>
            @endisset
        </div>
    </div>
</div>
 {{-- modal delete --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa thể loại</h5>
            </div>
            <div class="modal-body">
            <form method="POST">
                @csrf
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa thể loại</h6><span id="confirmCategory"></span><h6>(Sản phẩm của thể loại cũng sẽ bị xóa)</h6></label>
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
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa thể loại</h5>
            </div>
            <div class="modal-body">
            <form method="POST">
                @csrf
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa các thể loại đã chọn</h6><h6>(Sản phẩm của các thể loại cũng sẽ bị xóa)</h6></label>
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

{{-- modal update --}}
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập nhật thể loại</h5>
            </div>
            <div class="modal-body">
            <form method="POST">
                @csrf
                <input type="hidden" class="form-control" name="updateId" >
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Tên:</h6><span id="confirmCategory"></span></label>
                    <input type="text" class="form-control" id="nameCategory">
                    <div class="invalid-feedback" id="errorName">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Mô tả:</h6><span id="confirmCategory"></span></label>
                    <input type="text" class="form-control" id="descCategory">
                    <div class="invalid-feedback" id="errorDesc">
                    </div>
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
@isset($categories)
{{-- modal create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm thể loại</h5>
            </div>
            <div class="modal-body">
            <form method="POST" id="createForm" action="{{url('admin/categories/create')}}">
                @csrf
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Tên:</h6></label>
                    <input type="text" class="form-control" id="nameCreateCategory" name="name">
                    <div class="invalid-feedback" id="errorCreateName">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Mô tả:</h6></label>
                    <input type="text" class="form-control" id="descCreateCategory" name="desc">
                    <div class="invalid-feedback" id="errorCreateDesc">
                    </div>
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
@endisset
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
{{-- data for delete modal boostrap --}}
<script>
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var name = button.data('name') 
    var id = button.data('id')
    var modal = $(this)
    modal.find('#confirmCategory').text(name)
    modal.find('input[name=deleteId]').val(id)
    });
</script>
{{-- validation delete modal & ajax --}}
<script>
    $(document).ready(function(){
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
                    url: "/admin/categories/"+$("input[name=deleteId]").val()+"/delete",
                    data: {"_token": "{{ csrf_token() }}", 'confirmPassword': $("input[name=confirmPasswordDelete]").val()},
                    success: function(data){
                        window.location.reload()
                    }
                });
            }
        })
    });

</script>

{{-- validation delete mutiple modal & ajax --}}
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
                    url: "/admin/categories/mutipledelete",
                    data: {"_token": "{{ csrf_token() }}", 'mutipleId' : obj, 'confirmPassword': $("input[name=confirmPasswordDeleteMutiple]").val()},
                    success: function(data){
                        window.location.reload()                    
                    }
                });
            }
        })
    });
</script>
{{-- delete multiply --}}
<script>
    $(document).ready(function(){
        $("#deleteMutiple").click(function(){
            if ($('.checkbox:checked').length == 0) {
                $("#textNotificationDeleteMutipleModal").text("Vui lòng chọn ít nhất 1 records");
                $("#notificationDeleteMutipleModal").modal('show')
            } else {
                $("#confirmDeleteMutipleModal").modal('show')
            }
	    })
        // Select/Deselect checkboxes
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

{{-- data for update modal boostrap --}}
<script>
    $('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var name = button.data('name') // Extract info from data-* attributes
    var id = button.data('id')
    var desc = button.data('desc')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#nameCategory').val(name)
    modal.find('#descCategory').val(desc)
    modal.find('input[name=updateId]').val(id)
    });
</script>
{{-- validation update modal & ajax --}}
<script>
    $(document).ready(function(){
        $("#buttonUpdate").click(function(){
            let $checkName = false
            let $checkDesc = false
            if ($("#nameCategory").val() == ''){
                $("#nameCategory").addClass('is-invalid');
                $("#errorName").text('Vui lòng không để trống trường này')
                $checkName = false
            } else {
                $("#nameCategory").removeClass('is-invalid');
                $("#errorName").text('')
                $checkName = true
            }
            if ($("#descCategory").val() == ''){
                $("#descCategory").addClass('is-invalid');
                $("#errorDesc").text('Vui lòng không để trống trường này')
                $checkDesc = false
            } else {
                $("#descCategory").removeClass('is-invalid');
                $("#errorDesc").text('')
                $checkDesc = true
            }
            if ($checkName == true && $checkDesc == true){
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/admin/categories/"+$("input[name=updateId]").val()+"/update",
                        data: {"_token": "{{ csrf_token() }}", 'name': $("#nameCategory").val(),'desc': $("#descCategory").val()},
                        success: function(data){
                            window.location.reload()
                        }
                    });
            }
        })
    });

</script>
{{-- create modal  --}}
<script>
    $(document).ready(function(){
        $("#buttonCreate").click(function(){
            let $checkName = false
            let $checkDesc = false
            if ($("#nameCreateCategory").val() == ''){
                $("#nameCreateCategory").addClass('is-invalid');
                $("#errorCreateName").text('Vui lòng không để trống trường này')
                $checkName = false
            } else {
                $("#nameCreateCategory").removeClass('is-invalid');
                $("#errorCreateName").text('')
                $checkName = true
            }
            if ($("#descCreateCategory").val() == ''){
                $("#descCreateCategory").addClass('is-invalid');
                $("#errorCreateDesc").text('Vui lòng không để trống trường này')
                $checkDesc = false
            } else {
                $("#descCreateCategory").removeClass('is-invalid');
                $("#errorCreateDesc").text('')
                $checkDesc = true
            }
            if ($checkName == true && $checkDesc == true){
                $("#createForm").submit();
            }
        })
    });

</script>
@endpush