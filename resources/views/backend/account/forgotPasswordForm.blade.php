@extends('frontend.layouts.app')
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
                  <h3 class="font-weight-bolder text-info text-gradient">Đừng lo lắng</h3>
                  <p class="mb-0">Nhập email của bạn để tiến hành tạo lại mật khẩu mới</p>
                  @isset($loginFailed)
                    <small class="form-text text-muted"><span class="text-danger">{{$loginFailed}}</span></small>
                  @endisset
                </div>
                <div class="card-body">
                  <form role="form" method="POST">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" name="email">
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
        
      })
    });
  </script>
@endpush