@extends('backend.account.layouts.app')
@section('title')
    Quên mật khẩu
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
                  <h3 class="font-weight-bolder text-info text-gradient">Đừng lo lắng</h3>
                  <p class="mb-0">Nhập email của bạn để tiến hành tạo lại mật khẩu mới</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="{{url('admin/forgotpassword')}}">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" name="email">
                      <div class="invalid-feedback" id="errorEmail">
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn bg-gradient-info w-100 mt-4 mb-0" id="btnForgotPassword">Tạo mật khẩu mới</button>
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

@endsection
@push('js')
  <script>
    $(document).ready(function(){
      $("#btnForgotPassword").click(function(){
        $checkEmail = false
        let $regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        $emailInput = $("input[name=email]")
        if ($emailInput.val() == ''){
                $emailInput.addClass('is-invalid')
                $("#errorEmail").text("Trường này không được để trống")
                $checkEmail = false
            } else if ($regexEmail.test($emailInput.val()) == false){
                $emailInput.addClass('is-invalid')
                $("#errorEmail").text("Nhập đúng định dạng email")
                $checkEmail = false
            } else {
                $emailInput.removeClass('is-invalid')
                $("#errorEmail").text("")
                $checkEmail = true
            }
            if ($checkEmail == true){
              $('form').submit();
                // $.ajax({
                //     type: "POST",
                //     dataType: "json",
                //     url: "/admin/forgotpassword",
                //     timeout: 3000,
                //     data: {"_token": "{{ csrf_token() }}", 'email': $emailInput.val()},
                //     success: function(data){
                //         if (data.result == 'notExists'){
                //           $emailInput.addClass('is-invalid')
                //           $("#errorEmail").text("Email này chưa được đăng ký")
                //         } else {
                //           $("#notificationResetPasswordModal").modal('show')
                //         }
                //     },
                // });
            }
      })   
      $('#closeNotificationResetPasswordModal').click(function(){
        location.reload()
      })
    });
  </script>
@endpush