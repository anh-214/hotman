@extends('backend.layouts.app')

@section('title')
    Quản lí sản phẩm
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí sản phẩm</h6>
                    <div>
                        @isset($products)
                            <a type="button" class="text-secondary font-weight-bold text-xl" >
                                <span class="badge badge-sm bg-gradient-success" data-bs-toggle="modal" data-bs-target="#createModal">Thêm</span>
                            </a>
                            <a type="button" class="text-secondary font-weight-bold text-xl" id="deleteMutiple" >
                                <span class="badge badge-sm bg-gradient-danger">Xóa số lượng lớn</span>
                            </a>
                        @endisset
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2 mx-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="p-2 mx-0">
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="selectAll">
                                            <label for="selectAll"></label>
                                        </span>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Description</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Category_id_name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Created_at</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Updated_at</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Action</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                {{-- view product --}}
                                @isset($product) 
                                    <tr class="bg-light">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$product->id}}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->name}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->desc}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> 
                                                <a href="{{url('admin/categories/?id='.$product->category_id)}}" type="button" class="text-secondary">
                                                    {{$product->category_id.' - '.$product->category->name}}
                                                </a>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('/admin/types?product_id='.$product->id)}}" >
                                                <span class="badge badge-sm bg-gradient-primary">Tất cả loại sản phẩm</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs btnUpdate" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="{{$product->name}}" data-desc="{{$product->desc}}" data-id="{{$product->id}}" data-categoryid="{{$product->category_id}}" >
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-name="{{$product->name}}" data-id="{{$product->id}}" >
                                                <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endisset
                                @isset($products) 
                                @foreach ($products as $product )
                                    <tr>
                                        <td class="p-2 mx-0">
                                            <span class="custom-checkbox">
                                                <input type="checkbox" class="checkbox" name="checkbox[]" value="{{$product->id}}">
                                                <label></label>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$product->id}}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->name}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->desc}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> 
                                                <a href="{{url('admin/categories/?id='.$product->category_id)}}" type="button" class="text-secondary">
                                                    {{$product->category_id.' - '.$product->category->name}}
                                                </a>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"> {{$product->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('/admin/types?product_id='.$product->id)}}" >
                                                <span class="badge badge-sm bg-gradient-primary">Tất cả loại sản phẩm</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs btnUpdate" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="{{$product->name}}" data-desc="{{$product->desc}}" data-id="{{$product->id}}" data-categoryid="{{$product->category_id}}" >
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-name="{{$product->name}}" data-id="{{$product->id}}" >
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
            @isset($products)
                <div class="d-flex justify-content-center">{{$products->links('vendor.pagination.bootstrap-4')}}</div>
            @endisset
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" id="createForm" action="{{url('admin/products/create')}}">
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
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Category:</h6></label>
                    <select name="category_id" class="form-select">
                        @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->id.' - '.$category->name}}</option>
                        @endforeach
                    </select>
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
@isset($products)
{{-- modal delete --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa sản phẩm: </h6><span id="confirmCategory"></span><h6>(Loại sản phẩm của sản phẩm cũng sẽ bị xóa)</h6></label>
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
@endisset
{{-- modal notification --}}
<div class="modal fade" id="notificationModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="textNotificationModal">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="closeNotificationModal" data-bs-dismiss="modal" aria-label="Close">Đóng</button>
            </div>
        </div>
    </div>
</div>

{{-- modal update --}}
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập nhật sản phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST">
                @csrf
                <input type="hidden" class="form-control" name="updateId" >
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Tên:</h6></span></label>
                    <input type="text" class="form-control" id="nameProduct" name="nameProduct">
                    <div class="invalid-feedback" id="errorName">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Mô tả:</h6></span></label>
                    <input type="text" class="form-control" id="descProduct" name="descProduct">
                    <div class="invalid-feedback" id="errorDesc">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Category:</h6></label>
                    <select name="category_id_update" class="form-select">
                        @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->id.' - '.$category->name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="errorCreateDesc">
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
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa các sản phẩm đã chọn</h6><h6>(Loại sản phẩm của các sản phẩm cũng sẽ bị xóa)</h6></label>
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
{{-- modal notification delete multiple --}}
<div class="modal fade" id="notificationDeleteMutipleModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="textNotificationDeleteMutipleModal">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="closeNotificationDeleteMutipleModal"  data-bs-dismiss="modal" aria-label="Close">Đóng</button>
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
                    url: "/admin/products/delete",
                    data: {"_token": "{{ csrf_token() }}", 'mutipleId' : obj, 'confirmPassword': $("input[name=confirmPasswordDeleteMutiple]").val()},
                    success: function(data){
                        if (data.result == 'success'){
                            $("#confirmDeleteMutipleModal").modal('hide')
                            $("#textNotificationDeleteMutipleModal").text('Xóa sản phẩm thành công')
                            $("#notificationDeleteMutipleModal").modal('show')
                        } else {
                            $("#confirmDeleteMutipleModal").modal('hide')
                            $("#textNotificationDeleteMutipleModal").text('Xóa sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu')
                            $("#notificationDeleteMutipleModal").modal('show')
                        }
                    
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
        $("#closeNotificationDeleteMutipleModal").click(function(){
            location.reload();
        })
    });
</script>

{{-- data for delete modal boostrap --}}
<script>
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var name = button.data('name') // Extract info from data-* attributes
    var id = button.data('id')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
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
                    url: "/admin/products/delete",
                    data: {"_token": "{{ csrf_token() }}", 'deleteId': $("input[name=deleteId]").val(), 'confirmPassword': $("input[name=confirmPasswordDelete]").val()},
                    success: function(data){
                        if (data.result == 'success'){
                            $("#confirmDeleteModal").modal('hide')
                            $("#textNotificationModal").text('Xóa sản phẩm thành công')
                            $("#notificationModal").modal('show')
                        } else if (data.result == 'failed') {
                            $("#confirmDeleteModal").modal('hide')
                            $("#textNotificationModal").text('Xóa sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu')
                            $("#notificationModal").modal('show')
                        
                        }
                    
                    }
                });
            }
        })
        $("#closeNotificationModal").click(function(){
            location.reload()
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
{{-- data for update modal boostrap --}}
<script>
    $('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var name = button.data('name') // Extract info from data-* attributes
    var id = button.data('id')
    var desc = button.data('desc')
    var categoryId = button.data('categoryid')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#nameProduct').val(name)
    modal.find('#descProduct').val(desc)
    modal.find('input[name=updateId]').val(id)
    $("select[name=category_id_update] option").each(function(){
        if ($(this).val() == categoryId){
            $(this).attr('selected','selected')
        }
    })
    });
</script>
{{-- validation update modal & ajax --}}
<script>
    $(document).ready(function(){
        $("#buttonUpdate").click(function(){
            let $checkName = false
            let $checkDesc = false
            if ($("#nameProduct").val() == ''){
                $("#nameProduct").addClass('is-invalid');
                $("#errorName").text('Vui lòng không để trống trường này')
                $checkName = false
            } else {
                $("#nameProduct").removeClass('is-invalid');
                $("#errorName").text('')
                $checkName = true
            }
            if ($("#descProduct").val() == ''){
                $("#descProduct").addClass('is-invalid');
                $("#errorDesc").text('Vui lòng không để trống trường này')
                $checkDesc = false
            } else {
                $("#descProduct").removeClass('is-invalid');
                $("#errorDesc").text('')
                $checkDesc = true
            }
            if ($checkName == true && $checkDesc == true){
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/admin/products/update",
                        data: {"_token": "{{ csrf_token() }}", 'id': $("input[name=updateId]").val(), 'name': $("#nameProduct").val(),'desc': $("#descProduct").val(), 'category_id': $("select[name=category_id_update]").val()},
                        success: function(data){
                            if (data.result == 'success'){
                                $("#updateModal").modal('hide')
                                $("#textNotificationModal").text('Cập nhật thành công')
                                $("#notificationModal").modal('show')
                            } else {
                                $("#updateModal").modal('hide')
                                $("#textNotificationModal").text('Cập nhật thất bại')
                                $("#notificationModal").modal('show')
                            }
                        }
                    });
            }
        })
        $("#closeNotificationModal").click(function(){
            location.reload()
        })
    });

</script>
@endpush