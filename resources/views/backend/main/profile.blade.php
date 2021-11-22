@extends('backend.layouts.app')

@section('title')
    Hồ sơ của tôi
@endsection

@push('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>    
@endpush

@section('content')
<!-- End Navbar -->
<div class="container-fluid">
    <div class="page-header min-height-200 border-radius-xl mt-4" style="background-image: url({{asset('backend/assets/images/curved-images/curved0.jpg')}}); background-position-y: 50%;">
        <span class="mask opacity-6"></span>
    </div>
    <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{Storage::disk('admin-avatar')->url($admin->avatar == null ? 'unknown.png' : $admin->avatar)}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                <h5 class="mb-1">
                    {{$admin->name}}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    {{$admin->email}}
                </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                    {{-- setting --}}
                    {{-- <li class="nav-item" id="setting">
                        <a class="nav-link mb-0 px-0 py-1 active "  data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                            <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                    <g transform="translate(603.000000, 0.000000)">
                                    <path class="color-background" d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                    </path>
                                    <path class="color-background" d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z" opacity="0.7"></path>
                                    <path class="color-background" d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z" opacity="0.7"></path>
                                    </g>
                                </g>
                                </g>
                            </g>
                            </svg>
                            <span class="ms-1">Cài đặt</span>
                        </a>
                    </li> --}}
                    {{-- update --}}
                    <li class="nav-item" id="update" >
                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>document</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(154.000000, 300.000000)">
                                <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                </path>
                                </g>
                            </g>
                            </g>
                        </g>
                        </svg>
                        <span class="ms-1">Cập nhật</span>
                    </a>
                    </li>
                    {{-- change password --}}
                    <li class="nav-item" id="changePassword">
                    <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>settings</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(304.000000, 151.000000)">
                                <polygon class="color-background" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667">
                                </polygon>
                                <path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                <path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z">
                                </path>
                                </g>
                            </g>
                            </g>
                        </g>
                        </svg>
                        <span class="ms-1">Đổi mật khẩu</span>
                    </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
    <div class="row">
        {{-- <div class="col-12 col-xl-12" id="settingContent">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Platform Settings</h6>
                </div>
                <div class="card-body p-3">
                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Account</h6>
                <ul class="list-group">
                    <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" checked>
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">Email me when someone follows me</label>
                    </div>
                    </li>
                    <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault1">
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault1">Email me when someone answers on my post</label>
                    </div>
                    </li>
                    <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault2" checked>
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault2">Email me when someone mentions me</label>
                    </div>
                    </li>
                </ul>
                <h6 class="text-uppercase text-body text-xs font-weight-bolder mt-4">Application</h6>
                <ul class="list-group">
                    <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault3">
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault3">New launches and projects</label>
                    </div>
                    </li>
                    <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault4" checked>
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault4">Monthly product updates</label>
                    </div>
                    </li>
                    <li class="list-group-item border-0 px-0 pb-0">
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault5">
                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault5">Subscribe to newsletter</label>
                    </div>
                    </li>
                </ul>
                </div>
            </div>
        </div> --}}

        <div class="col-12 col-xl-6" id="updateContent">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                        <h6 class="mb-0">Cập nhật thông tin tài khoản</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="updateNameInput" class="col-form-label"><h6>Tên: </h6> </label>
                            <input type="hidden" class="form-control" id="confirmUpdateId" value="{{$admin->id}}">
                            <input type="text" class="form-control" id="updateNameInput" value="{{$admin->name}}">
                            <div class="invalid-feedback" id="errorUpdateNameInput">
                            </div>
                            <label for="updateNameInput" class="col-form-label"><h6>Avatar: </h6> </label>
                            <div class="input-group">
                                <input type="file" class="form-control image" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="upload" accept="image/*">
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="preview" id="preview"></div>
                                </div>
                            </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="button" id="updateInformationButton" class="btn btn-success">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6" id="changePasswordContent">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Đổi mật khẩu</h6>
                </div>
                <div class="card-body p-3">
                {{-- <ul class="list-group">
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                        <img src="../assets/img/kal-visuals-square.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Sophie B.</h6>
                        <p class="mb-0 text-xs">Hi! I need more information..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                    </li>
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                        <img src="../assets/img/marie.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Anne Marie</h6>
                        <p class="mb-0 text-xs">Awesome work, can you..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                    </li>
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                        <img src="../assets/img/ivana-square.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Ivanna</h6>
                        <p class="mb-0 text-xs">About files I can..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                    </li>
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                        <img src="../assets/img/team-4.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Peterson</h6>
                        <p class="mb-0 text-xs">Have a great afternoon..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                    </li>
                    <li class="list-group-item border-0 d-flex align-items-center px-0">
                    <div class="avatar me-3">
                        <img src="../assets/img/team-3.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Nick Daniel</h6>
                        <p class="mb-0 text-xs">Hi! I need more information..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                    </li>
                </ul> --}}
                <form enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="updateNameInput" class="col-form-label"><h6>Mật khẩu cũ: </h6> </label>
                        <input type="text" class="form-control" name="oldPassword">
                        <div class="invalid-feedback" id="errorOldPasswordInput">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="updateNameInput" class="col-form-label"><h6>Mật khẩu mới: </h6> </label>
                        <input type="text" class="form-control" name="password">
                        <div class="invalid-feedback" id="errorPasswordInput">
                        </div>
                    </div>
                    <div class="mb-3 ">
                        <label for="updateNameInput" class="col-form-label"><h6>Nhập lại mật khẩu mới: </h6> </label>
                        <input type="text" class="form-control" name="confirmPassword">
                        <div class="invalid-feedback" id="errorConfirmPasswordInput">
                        </div>
                    </div>   
                    <div class="d-flex flex-row-reverse">
                        <button type="button" id="updatePasswordButton" class="btn btn-success">Cập nhật mật khẩu</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

{{-- preview and crop avatar --}}
    <div class="modal fade" id="previewModal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Cắt ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>         
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
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
    max-width: 1000px !important;
    
    }
    .btn{
        margin-bottom: 0px
    }
    </style>
@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    {{-- change password --}}
    <script>
        $(document).ready(function(){
            // select
            // $('#updateContent').addClass('d-none');
            $('#changePasswordContent').addClass('d-none');
            // function chooseSetting(){
            //     $('#changePasswordContent').addClass('d-none');
            //     $('#updateContent').addClass('d-none');
            //     $('#settingContent').removeClass('d-none');
            // }
            function chooseUpdate(){
                $('#changePasswordContent').addClass('d-none');
                // $('#settingContent').addClass('d-none');
                $('#updateContent').removeClass('d-none');
            }
            function chooseChangePassword(){
                $('#changePasswordContent').removeClass('d-none');
                $('#updateContent').addClass('d-none');
                // $('#settingContent').addClass('d-none');
            }
            $("#update").click(function(){
                chooseUpdate()
            });
            // $("#setting").click(function(){
            //     chooseSetting()
            // });
            $("#changePassword").click(function(){
                chooseChangePassword()
            });
            // check validation
            $oldPasswordInput = $("input[name=oldPassword]")
            $passwordInput = $("input[name=password]")
            $confirmPasswordInput = $("input[name=confirmPassword]")
            $("#updatePasswordButton").click(function(e){
                e.preventDefault();
                let $checkOldPassword = false
                let $checkPassword = false
                if ($oldPasswordInput.val() == ''){
                    $oldPasswordInput.addClass('is-invalid')
                    $("#errorOldPasswordInput").text("Trường này không được để trống")
                    $checkOldPassword = false
                } else {
                    $oldPasswordInput.removeClass('is-invalid')
                    $("#errorOldPasswordInput").text("")
                    $checkOldPassword = true
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
                if ($checkPassword == true && $checkOldPassword == true){
                    $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/profile/changepassword",
                    timeout: 3000,
                    data: {"_token": "{{ csrf_token() }}", 'oldPassword': $oldPasswordInput.val(), 'password': $passwordInput.val()},
                    success: function(data){
                        window.location.reload()
                    },
                    fail: function(err){
                        console.log(err)
                    }
                });
                }
            })
            $('.goToSetting').click(function(){
                location.reload()
            });
        });
    </script>  

    {{-- update information --}}
    <script>
        $(document).ready(function(){
            var $modal = $('#previewModal');
            var image = document.getElementById('image');
            var cropper;
            $('#preview').hide()
            $("#updateContent").on("change", ".image", function(e){
                if ($('#preview').is(":visible")){
                    cropper.destroy();
                    cropper == null
                }
                image.src = '';
                $('#preview').show()
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
            $modal.on('show.bs.modal', function () {
                cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
                });
            });   
            $("#crop").click(function(){
                $modal.modal('hide');
                });
                $('#closePreview').click(function(){
                $('#preview').hide() 
                $('.image').val('')
                cropper.destroy();
                cropper == null
            })
            $("#updateInformationButton").click(function(){
                $checkInformationName = false
                if ($("#updateNameInput").val() == '' ){
                    $("#updateNameInput").addClass('is-invalid')
                    $("#errorUpdateNameInput").text("Vui lòng không để trống trường này")
                    $checkInformationName = false
                } else if ($("#updateNameInput").val().length <5 ){
                    $("#updateNameInput").addClass('is-invalid')
                    $("#errorUpdateNameInput").text("Trường này phải trên 5 kí tự")
                    $checkInformationName = false 
                } else {
                    $("#updateNameInput").removeClass('is-invalid')
                    $("#errorUpdateNameInput").text("")
                    $checkInformationName = true
                }
                if ($('.image').val() != '' && $checkInformationName == true){
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
                                url: "/admin/profile/update",
                                data: {"_token": "{{ csrf_token() }}", 'upload': base64data, 'id': $("#confirmUpdateId").val(), 'name': $("#updateNameInput").val()},
                                success: function(data){
                                    window.location.reload()
                                }
                            });
                        }
                    });
                } else if ($('.image').val() == '' && $checkInformationName == true){
                    $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/profile/update",
                    data: {"_token": "{{ csrf_token() }}", 'id': $("#confirmUpdateId").val(), 'name': $('#updateNameInput').val()},
                    success: function(data){
                        window.location.reload()
                    }
                });
                }; 
            });
            $('#closeNotificationUpdateModal').click(function(){
                location.reload()
            })
        });
    </script>
@endpush