@extends('backend.layouts.app')

@section('title')
    Quản lí sản phẩm
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
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-1">
                            <thead>
                                <tr>
                                    <th class="p-4">
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="selectAll">
                                            <label for="selectAll"></label>
                                        </span>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Initial_price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Images</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Designs</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Details</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Material</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Sizes</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Colors</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-0">Product_id</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-0">Created_at</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Action</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type )
                                    <tr>
                                        <td class="p-4">
                                            <span class="custom-checkbox">
                                                <input type="checkbox" class="checkbox" name="checkbox[]" value="{{$type->id}}">
                                                <label></label>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$type->id}}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->name}}"> {{$type->name}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-center"> {{$type->price}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-center"> {{$type->initial_price}}</p>
                                        </td>
                                        <td>
                                            <p type="button" class="text-xs font-weight-bold mb-0 text-center showImages" data-id="{{$type->id}}">                                              
                                                    Xem
                                            </p>
                                        </td>
                                        
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->designs}}"> {{$type->designs}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->details}}"> {{$type->details}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->material}}">{{$type->material}}</p>
                                        </td>
                                        <td >
                                            <select class="text-xs font-weight-bold mb-0 hint-text">
                                                @php
                                                    $sizes = explode(",",$type->sizes);
                                                @endphp
                                                @foreach ($sizes as $size)
                                                    <option class="text-xs">{{$size}}</option>    
                                                @endforeach
                                                

                                            </select>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->color}}">{{$type->color}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-center hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->product_id.' - '.$type->product->name}}">
                                                <a href="{{url('admin/products/?id='.$type->product_id)}}" type="button" class="text-secondary">
                                                    {{$type->product_id.' - '.$type->product->name}}
                                                </a>
                                            </p>                            
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$type->created_at}}"> {{$type->created_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('admin/types/update?id='.$type->id)}}">
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
                <button class="btn btn-primary" id="closeNotificationDeleteMutipleModal"  data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload()">Đóng</button>
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
                    url: "/admin/types/delete",
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
                    url: "/admin/types/delete",
                    data: {"_token": "{{ csrf_token() }}", 'deleteId': $("input[name=deleteId]").val(), 'confirmPassword': $("input[name=confirmPasswordDelete]").val()},
                    success: function(data){
                        if (data.result == 'success'){
                            $("#confirmDeleteModal").modal('hide')
                            $("#textNotificationModal").text('Xóa loại sản phẩm thành công')
                            $("#notificationModal").modal('show')
                        } else if (data.result == 'failed') {
                            $("#confirmDeleteModal").modal('hide')
                            $("#textNotificationModal").text('Xóa loại sản phẩm thất bại, vui lòng kiểm tra lại mật khẩu')
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