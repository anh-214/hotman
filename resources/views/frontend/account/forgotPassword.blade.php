@extends('frontend.account.layouts.app')

@section('title')
    Quên mật khẩu
@endsection
@push('css')
  <style>
    .custom-btn-forgot{
      color: white;
      background-color: #F7941D ; 
    }
    #github{
      color: black;
      font-size: 24pt;
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
                <h1 class="text-white mb-2 mt-5">Đừng lo lắng !</h1>
                <p class="text-lead text-white">Nhập email của bạn để tiến hành tạo lại mật khẩu mới</p>
            </div>
            </div>
        </div>
        </div>
        <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
                <div class="card-body">
                <form role="form" method="POST" class="py-3" action="{{url('user/forgotpassword')}}">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" name="email">
                        <div class="invalid-feedback" id="errorEmail">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="custom-btn-forgot btn w-100 mt-4 mb-0" id="btn-forgot">Lấy mật khẩu</button>
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
        $email = $('input[name=email]');
        let $checkEmail = false;
        let $regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

        if ($email.val() == ''){
            $email.addClass('is-invalid')
            $("#errorEmail").text("Trường này không được để trống")
            $checkEmail = false
        } else if ($regexEmail.test($email.val()) == false){
            $email.addClass('is-invalid')
            $("#errorEmail").text("Nhập đúng định dạng email")
            $checkEmail = false
        } else {
            $email.removeClass('is-invalid')
            $("#errorEmail").text("")
            $checkEmail = true
        }
        if ($checkEmail == true ){
            $('form').submit();
        }
    })
})
</script>
@endpush