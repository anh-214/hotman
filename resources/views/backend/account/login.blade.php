@extends('backend.account.layouts.app')
@section('title')
    Đăng nhập
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
                  <h3 class="font-weight-bolder text-info text-gradient">Chào mừng quay trở lại</h3>
                  <p class="mb-0">Đăng nhập với tư cách quản trị viên để tiếp tục </p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" name="email">
                      <div class="invalid-feedback" id="errorEmail">
                      </div>
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" name="password">
                      <div class="invalid-feedback" id="errorPassword">
                      </div>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="" name="remember">
                      <label class="form-check-label" for="rememberMe">Nhớ mật khẩu</label>
                    </div>
                    <div class="text-center">
                      <button type="button" id="btn-login" class="btn bg-gradient-info w-100 mt-4 mb-0">Đăng nhập</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Bạn quên mật khẩu ?
                    <a href="{{url('/admin/forgotpassword')}}" class="text-info text-gradient font-weight-bold">Lấy lại mật khẩu</a>
                  </p>
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
  
@endsection
@push('js')
    <script>
      $(document).ready(function(){
    $("#btn-login").click(function(){
        $email = $('input[name=email]');
        $password = $('input[name=password]');

        let $checkEmail = false;
        let $checkPassword = false;
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

        if ($password.val() == ''){
            $password.addClass('is-invalid')
            $("#errorPassword").text("Trường này không được để trống")
            $checkPassword = false
        } else if ($password.val().length < 8 ){
            $password.addClass('is-invalid')
            $("#errorPassword").text("Mật khẩu phải lớn hơn hoặc bằng 8 kí tự")
            $checkPassword = false
        } else {
            $password.removeClass('is-invalid')
            $("#errorPassword").text("")
            $checkPassword = true
        }
        if ($checkEmail == true && $checkPassword == true){
            $('form').submit();
        }
    })
})
    </script>
@endpush