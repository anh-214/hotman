@extends('frontend.layouts.app')
@section('title')
    Tạo mật khẩu
@endsection
@section('content')
    <div class="js">
    <!-- Start changePassword -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Tạo mật khẩu</h4>
								</div>
								<form class="form" method="POST" action="{{url('/user/createpassword')}}">
                                    @csrf
									<div class="row">
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Mật khẩu<span>*</span></label>
												<input class="form-control" type="text" name="password">
                                                <div class="invalid-feedback" id="errorPassword">
                                                </div>
											</div>
										</div>
										
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Nhập lại mật khẩu<span>*</span></label>
												<input class="form-control" name="confirmpassword" >
                                                <div class="invalid-feedback" id="errorConfirmPassword">
                                                </div>
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="button" class="btn" id="btnCreatePassword">Tạo mật khẩu</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						
					</div>
				</div>
			</div>
	</section>
	<!--/ End change Password -->
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $("#btnCreatePassword").click(function(){
            $password = $('input[name=password]');
            $confirmPassword = $('input[name=confirmpassword]');

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