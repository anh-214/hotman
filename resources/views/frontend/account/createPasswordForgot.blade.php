@extends('frontend.account.layouts.app')

@section('title')
    Tạo mật khẩu mới
@endsection
@push('css')
  <style>
    .custom-btn-forgot{
      color: white;
      background-color: #F7941D ; 
    }
   
  </style>
@endpush
@section('content')
    <!-- Body -->
    <section class="min-vh-100 mb-8">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11  m-3 border-radius-lg" style="background-image: url({{asset('backend/assets/images/curved-images/curved14.jpg')}});">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white mb-2 mt-5">Chào mừng quay trở lại {{$email}}</h1>
                <p class="text-lead text-white">Điền vào form bên dưới để tiến hành tạo mật khẩu mới</p>
            </div>
            </div>
        </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                    <form role="form" method="POST" class="py-3" action="{{url('user/createpassword/'.$token)}}">
                        @csrf
                        <label>Mật khẩu</label>
                        <div class="mb-3">
                            <input type="text" class="form-control"  aria-describedby="email-addon" name="password">
                            <div class="invalid-feedback" id="errorPassword">
                            </div>
                        </div>
                        <label>Nhập lại mật khẩu</label>
                        <div class="mb-3">
                            <input type="text" class="form-control"  aria-describedby="email-addon" name="confirmPassword">
                            <div class="invalid-feedback" id="errorConfirmPassword">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="custom-btn-forgot btn w-100 mt-4 mb-0" id="btn-forgot">Tạo mật khẩu mới</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>
@push('js')
<script>
$(document).ready(function(){
        $("#btn-forgot").click(function(){
            $password = $('input[name=password]');
            $confirmPassword = $('input[name=confirmPassword]');

            if ($password.val() == ''){
                $password.addClass('is-invalid')
                $("#errorPassword").text("Trường này không được để trống")
            } else if ($password.val().length < 8 ){
                $password.addClass('is-invalid')
                $("#errorPassword").text("Trường này phải lớn hơn hoặc bằng 8 kí tự")
            } else {
                $password.removeClass('is-invalid')
                $("#errorPassword").text("")
                if ($confirmPassword.val() != $password.val()){
                $confirmPassword.addClass('is-invalid')
                $("#errorConfirmPassword").text("Mật khẩu không khớp")
                } else {
                    $confirmPassword.removeClass('is-invalid')
                    $("#errorConfirmPassword").text("")
                    $('form').submit();
                }
            }
        })
    })
</script>
@endpush