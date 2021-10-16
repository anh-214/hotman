@extends('backend.account.layouts.app')
@section('title')
    Tạo mật khẩu mới
@endsection

@section('content')    
<div class="container position-sticky z-index-sticky top-0">
<div class="row">
</div>
</div>
<main class="main-content  mt-0">
<section>
    <div class="page-header min-vh-75">
    <div class="container">
        <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-8">
            <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-info text-gradient">Xin chào {{$email}} </h3>
                <p class="mb-0">Hãy nhập mật khẩu mới của bạn</p>
            </div>
            <div class="card-body">
                <form role="form" method="POST" action="{{url('admin/createpassword/'.$token)}}">
                @csrf
                <label>Mật khẩu mới</label>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Mật khẩu mới" aria-label="Email" aria-describedby="email-addon" name="password">
                    <div class="invalid-feedback" id="errorPassword">
                    </div>
                </div>
                <label>Xác nhận mật khẩu mới</label>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Nhập lại mật khẩu mới" aria-label="Email" aria-describedby="email-addon" name="confirmPassword">
                    <div class="invalid-feedback" id="errorConfirmPassword">
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="btn bg-gradient-info w-100 mt-4 mb-0" id="btnCreatePassword">Tạo mật khẩu mới</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url({{asset('backend/assets/images/curved-images/curved6.jpg')}})"></div>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
</main>

{{-- modal notification create password --}}
<div class="modal fade" id="notificationCreatePasswordModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalToggleLabel">Thông báo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="textNotificationResetPasswordModal">
            Bạn đã tạo mật khẩu mới thành công, vui lòng đăng nhập
        </div>
        <div class="modal-footer">
            <a onclick="window.location = '{{url('/admin/login')}}'" >
            <button class="btn bg-gradient-info" id="closeNotificationCreatePasswordModal" data-bs-dismiss="modal" aria-label="Close">Đóng</button></a>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function(){
    $("#btnCreatePassword").click(function(e){
        e.preventDefault();
        $passwordInput = $("input[name=password]")
        $confirmPasswordInput = $("input[name=confirmPassword]")
        let $checkPassword = false
        if ($passwordInput.val() == ''){
            $passwordInput.addClass('is-invalid')
            $("#errorPassword").text("Trường này không được để trống")
            $checkPassword = false
        } else if ($passwordInput.val().length < 8 ){
            $passwordInput.addClass('is-invalid')
            $("#errorPassword").text("Mật khẩu phải lớn hơn hoặc bằng 8 kí tự")
            $checkPassword = false
        } else {
            $passwordInput.removeClass('is-invalid')
            $("#errorPassword").text("")
            if ($confirmPasswordInput.val() != $passwordInput.val()){
            $confirmPasswordInput.addClass('is-invalid')
            $("#errorConfirmPassword").text("Mật khẩu không khớp")
            $checkPassword = false
            } else {
                $confirmPasswordInput.removeClass('is-invalid')
                $("#errorConfirmPassword").text("")
                $checkPassword = true
            }
        }
        if ($checkPassword == true) {
            $('form').submit();
        }
    });   
});
</script>
@endpush