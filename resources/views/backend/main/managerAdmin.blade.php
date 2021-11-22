@extends('backend.layouts.app')

@section('title')
    Quản lí tài khoản Admin
@endsection
@push('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>    
@endpush
@section('content')
    
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí tài khoản</h6>
                    <a type="button" class="text-secondary font-weight-bold text-xl" >
                        <span class="badge badge-sm bg-gradient-success" data-bs-toggle="modal" data-bs-target="#createModal">Tạo mới</span>
                    </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-4">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quuyền</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian tạo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian cập nhật</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                                <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $admins as $admin )
                                    @if ($admin->id != Auth::guard('admin')->user()->id)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{Storage::disk('admin-avatar')->url( $admin->avatar == null ? 'unknown.png' : $admin->avatar)}}" class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$admin->name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$admin->email}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">@if($admin->role == '1'){{'Admin'}} @elseif ($admin->role == '2'){{'Manager'}} @else {{'Order'}} @endif</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{$admin->created_at}}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{$admin->updated_at}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a type="button" class="text-secondary font-weight-bold text-xs" >
                                                    <span class="badge badge-sm bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="{{$admin->id}}" data-name="{{$admin->name}}" data-role="{{$admin->role}}">Cập nhật</span>
                                                </a>
                                                <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-email="{{$admin->email}}" data-id="{{$admin->id}}">
                                                <span class="badge badge-sm bg-gradient-danger" >Xóa</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">{{$admins->links('vendor.pagination.bootstrap-4')}}</div>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="GET" id="deleteForm">
                        @csrf
                        <div class="mb-3">
                        <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa tài khoản</h6><span id="confirmEmail"></span></label>
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
        {{-- modal update --}}
        <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-custom">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="updateName" class="col-form-label"><h6>Tên: </h6> </label>
                                <input type="hidden" class="form-control" id="confirmUpdateId" >
                                <input type="text" class="form-control" id="updateName" >
                                <div class="invalid-feedback" id="errorUpdateName">
                                </div>
                                <label for="updateRole" class="col-form-label"><h6>Quyền: </h6> </label>
                                <select class="form-control" id="updateRole">
                                    <option value="" selected>Chọn</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Manager</option>
                                    <option value="3">Order</option>
                                </select>
                                <div class="invalid-feedback" id="errorUpdateRole">
                                </div>
                                <label  class="col-form-label"><h6>Avatar: </h6> </label>
                                <div class="input-group">
                                    <input type="file" class="form-control image" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="upload" accept="image/*">
                                </div>
                            </div>
                        </form>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="preview" id="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeUpdate">Thoát</button>
                                    <button type="button" id="update" class="btn btn-success">Cập nhật</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- modal create --}}
        <div class="modal fade" id="createModal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-custom">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tạo tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm" action="{{url('admin/manager/admins/create')}}" class="needs-validation" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="mb-3 no-border-bottom">
                                @error('email')
                                <small class="form-text text-muted"><span class="text-danger">{{$message}}</span></small>
                                @enderror
                                <label for="updateNameInput" class="col-form-label"><h6>Tên: </h6> </label>
                                <input type="text" class="form-control" name="name">
                                <div class="invalid-feedback" id="errorNameInput">
                                </div>
                                <label for="updateNameInput" class="col-form-label"><h6>Email: </h6> </label>
                                <input type="text" class="form-control" name="email">
                                <input type="hidden" name="emailExists">
                                <div class="invalid-feedback" id="errorEmailInput">
                                </div>
                                <label for="updateNameInput" class="col-form-label"><h6>Quyền: </h6> </label>
                                <select class="form-control" name="role">
                                    <option value="" selected>Chọn</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Manager</option>
                                    <option value="3">Order</option>
                                </select>
                                <div class="invalid-feedback" id="errorRoleInput">
                                </div>
                                <label for="updateNameInput" class="col-form-label"><h6>Mật khẩu: </h6> </label>
                                <input type="text" class="form-control" name="password" >
                                <div class="invalid-feedback" id="errorPasswordInput">
                                </div>
                                <label for="updateNameInput" class="col-form-label"><h6>Xác nhận mật khẩu: </h6> </label>
                                <input type="text" class="form-control" name="confirmPassword" >
                                <div class="invalid-feedback" id="errorConfirmPasswordInput">
                                </div>
                            </div>
                        </form>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeUpdate">Thoát</button>
                                    <button type="button" id="create" class="btn btn-success">Tạo</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    {{-- preview and crop avatar --}}
        <div class="modal fade" id="modal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Cắt ảnh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>         
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img id="image">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview" id="previewAndCrop"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closePreview">Thoát</button>
                        <button type="button" id="crop" class="btn btn-primary">Cắt</button>
                    </div>
                </div>
            </div>
        </div> 
@endsection

@push('css')
<style type="text/css">
    img {
    display: block;
    max-width: 100%;
    }
    .preview {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin: 10px;
    border: 1px solid red;
    }
    .modal-lg{
    max-width: 700px !important;
    
    }
    /* .modal-custom{
        max-width: 500px !important;
    } */
    .no-border-bottom{
        margin-bottom: 0px
    }
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('notificationModal'), {
    keyboard: false
    });
    myModal.show();
</script>

{{-- data for delete modal boostrap --}}
<script>
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var email = button.data('email') // Extract info from data-* attributes
    var id = button.data('id')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#confirmEmail').text(email)
    modal.find('input[name=deleteId]').val(id)
    let link = window.location.protocol + window.location.pathname+'/'+id+'/delete'
    // alert(link)
    modal.find('#deleteForm').attr('action', link)
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
                $('#deleteForm').submit();
            }
        })
    });

</script>
{{-- data for update modal boostrap ajax --}}
<script>
    $(document).ready(function(){
        // chọn ảnh mở modal preview & crop
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        let $checkName = false;
        let $checkRole = false;


        $("#updateModal").on("change", ".image", function(e){
            if ($('#preview').is(":visible")){
                cropper.destroy();
                cropper == null
            }
            $('#preview').show()
            image.src = '';
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                    done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        // when updateModal show
        $('#updateModal').on('show.bs.modal', function (event) {
            $('#preview').hide()
            // truyền name id
            var button = $(event.relatedTarget) 
            var name = button.data('name')
            var id = button.data('id')
            var role = button.data('role')
            var modal = $(this)
            modal.find('#updateName').val(name)
            modal.find('#confirmUpdateId').val(id)
            modal.find('option[value='+role+']').prop("selected", true)

        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper == null
            $('.image').val('');
        });
        
        $modal.on('show.bs.modal', function () {
            cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
            });
        });   
        $('#closePreview').click(function(){
            $('#preview').hide() 
            $('.image').val('')
            cropper.destroy();
            cropper == null
        })
        $("#crop").click(function(){
            $modal.modal('hide');
            $('#preview').show()  
            
        });
        $("#update").click(function(){
            if ($('#updateName').val() == ''){
                $('#updateName').addClass('is-invalid')
                $("#errorUpdateName").text("Trường này không được để trống")
                $checkName = false
            } else if ($('#updateName').val().length <5){
                $('#updateNameInput').addClass('is-invalid')
                $("#errorUpdateName").text("Trường này phải trên 5 kí tự")
                $checkName = false
            } else {
                $('#updateName').removeClass('is-invalid')
                $("#errorUpdateName").text("")
                $checkName = true
            }
            if($('#updateRole').val() == '' ){
                $('#updateRole').addClass('is-invalid')
                $("#errorUpdateRole").text("Trường này chưa được chọn")
                $checkRole = false
            } else {
                $('#updateRole').removeClass('is-invalid')
                $("#errorUpdateRole").text("")
                $checkRole = true
            }
            let link = window.location.protocol + window.location.pathname+'/'+$("#confirmUpdateId").val()+'/update'
            if ($('.image').val() != '' && $checkName == true){
                canvas = cropper.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob); 
                    reader.onloadend = function() {
                        var base64data = reader.result; 
                       

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: link,
                            data: {"_token": "{{ csrf_token() }}", 'upload': base64data, 'id': $("#confirmUpdateId").val(), 'name': $('#updateName').val(),'role':$('#updateRole').val()},
                            success: function(data){
                                window.location.reload()
                            }
                        });
                    }
                });
            } else if ($checkName == true) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: link,
                    data: {"_token": "{{ csrf_token() }}", 'id': $("#confirmUpdateId").val(), 'name': $('#updateName').val(),'role':$('#updateRole').val()},
                    success: function(data){
                       window.location.reload()
                    }
                });
            }
        });

        $("#closeResultUpdate").click(function(){
            location.reload();
        })
        
    });
</script>

{{-- create modal ajax --}}
<script>
    $(document).ready(function(){

        $nameInput = $("input[name=name]")
        $emailInput = $("input[name=email]")
        $roleInput = $("select[name=role]")
        $passwordInput = $("input[name=password]")
        $confirmPasswordInput = $("input[name=confirmPassword]")
        let $regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        let $checkName = false
        let $checkEmail = false
        let $checkRole = false
        let $checkPassword = false

        $nameInput.focusout(function(){
            let $name = $nameInput.val();
            if ($name == ''){
                $nameInput.addClass('is-invalid')
                $("#errorNameInput").text("Trường này không được để trống")
                
            } else if($name.length < 5 ){
                $nameInput.addClass('is-invalid')
                $("#errorNameInput").text("Trường này phải trên 5 kí tự")
            } else {
                $nameInput.removeClass('is-invalid')
                $("#errorNameInput").text("")
            }
        });
        $emailInput.focusout(function(){
            if ($emailInput.val() == ''){
                $emailInput.addClass('is-invalid')
                $("#errorEmailInput").text("Trường này không được để trống")             
            } else if($regexEmail.test($emailInput.val()) == false){
                $emailInput.addClass('is-invalid')
                $("#errorEmailInput").text("Nhập đúng định dạng email")
            } else {
                emailExists($emailInput.val()).done(function(data){
                    if (data.result == 'exists'){
                        $emailInput.addClass('is-invalid')
                        $("#errorEmailInput").text("Email đã tồn tại")     
                        $('input[name=emailExists]').val('true')
                    }
                    if (data.result == 'notExists'){
                        $emailInput.removeClass('is-invalid')
                        $("#errorEmailInput").text("")
                        $('input[name=emailExists]').val('false')
                    }
                })
            }
        });
        
        $passwordInput.focusout(function(){
            if ($passwordInput.val() == ''){
                $passwordInput.addClass('is-invalid')
                $("#errorPasswordInput").text("Trường này không được để trống")
            } else if ($passwordInput.val().length < 8 ){
                $passwordInput.addClass('is-invalid')
                $("#errorPasswordInput").text("Mật khẩu phải lớn hơn hoặc bằng 8 kí tự")
            } else {
                $passwordInput.removeClass('is-invalid')
                $("#errorPasswordInput").text("")
            }
        })

        $('#create').click(function(e){
            e.preventDefault()
            
            if ($nameInput.val() == ''){
                $nameInput.addClass('is-invalid')
                $("#errorNameInput").text("Trường này không được để trống") 
                $checkName = false
            } else if($nameInput.val().length < 5 ){
                $nameInput.addClass('is-invalid')
                $("#errorNameInput").text("Trường này phải trên 5 kí tự")
                $checkName = false
            } else {
                $nameInput.removeClass('is-invalid')
                $("#errorNameInput").text("")
                $checkName = true
            }
            if ($emailInput.val() == ''){
                $emailInput.addClass('is-invalid')
                $("#errorEmailInput").text("Trường này không được để trống")
                $checkEmail = false
            } else if ($regexEmail.test($emailInput.val()) == false){
                $emailInput.addClass('is-invalid')
                $("#errorEmailInput").text("Nhập đúng định dạng email")
                $checkEmail = false
            } else {
                $checkEmail = true
                emailExists($emailInput.val()).done(function(data){
                    if (data.result == 'exists'){
                        $emailInput.addClass('is-invalid')
                        $("#errorEmailInput").text("Email đã tồn tại")     
                        $('input[name=emailExists]').val('true')
                    }
                    if (data.result == 'notExists'){
                        $emailInput.removeClass('is-invalid')
                        $("#errorEmailInput").text("")
                        $('input[name=emailExists]').val('false')
                    }
                })
            }

            if($roleInput.val() == '' ){
                $roleInput.addClass('is-invalid')
                $("#errorRoleInput").text("Trường này chưa được chọn")
                $checkRole = false
            } else {
                $roleInput.removeClass('is-invalid')
                $("#errorRoleInput").text("")
                $checkRole = true
            }

            if ($passwordInput.val() == ''){
                $passwordInput.addClass('is-invalid')
                $("#errorPasswordInput").text("Trường này không được để trống")
                $checkPassword = false
            } else if ($passwordInput.val().length < 8 ){
                $passwordInput.addClass('is-invalid')
                $("#errorPasswordInput").text("Mật khẩu phải lớn hơn hoặc bằng 8 kí tự")
                $checkPassword = false
            } else {
                $passwordInput.removeClass('is-invalid')
                $("#errorPasswordInput").text("")
                if ($confirmPasswordInput.val() != $passwordInput.val()){
                $confirmPasswordInput.addClass('is-invalid')
                $("#errorConfirmPasswordInput").text("Mật khẩu không khớp")
                $checkPassword = false
                } else {
                    $confirmPasswordInput.removeClass('is-invalid')
                    $("#errorConfirmPasswordInput").text("")
                    $checkPassword = true
                }
            }

            if ($checkName == true && $checkEmail == true && $checkRole == true  && $checkPassword == true &&  $('input[name=emailExists]').val() == 'false'){

                $('#createForm').submit()
                // $.ajax({
                //     type: "POST",
                //     dataType: "json",
                //     url: "/admin/manager/create",
                //     timeout: 5000,
                //     data: {"_token": "{{ csrf_token() }}", 'name': $("input[name=nameInput]").val(), 'email': $("input[name=emailInput]").val(), 'role':, 'password': $("input[name=passwordInput]").val()},
                //     success: function(data){
                //         if (data.result == 'success'){
                //             location.reload()
                //         }
                //     },
                //     fail: function(err){
                //         console.log(err)
                //     }
                // });
            }

        });

        function emailExists($emailInput){
            return  $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/admin/manager/checkemailexists",
                        timeout: 3000,
                        data: {"_token": "{{ csrf_token() }}", 'email': $emailInput},
                        success: function(data){
                            return data
                        },
                    });
        }

    });
</script>


@endpush