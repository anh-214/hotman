@extends('frontend.layouts.app')
@section('title')
    Đổi mật khẩu
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
									<h4>Đổi mật khẩu</h4>
								</div>
								<form class="form" method="POST" action="{{url('/user/changepassword')}}">
                                    @csrf
									<div class="row">
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Mật khẩu cũ<span>*</span></label>
												<input class="form-control" name="oldpassword" type="text" placeholder="">
                                                <div class="invalid-feedback" id="errorOldPassword">
                                                </div>
											</div>
										</div>
										
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Mật khẩu mới<span>*</span></label>
												<input class="form-control" name="password"  placeholder="">
                                                <div class="invalid-feedback" id="errorPassword">
                                                </div>
											</div>	
										</div>
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Nhập lại mật khẩu mới<span>*</span></label>
												<input class="form-control" name="confirmpassword" type="text" placeholder="">
                                                <div class="invalid-feedback" id="errorConfirmPassword">
                                                </div>
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="button" class="btn" id="btn-changePassword">Cập nhật mật khẩu</button>
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
        $("#btn-changePassword").click(function(){
            $oldPassword = $('input[name=oldpassword]');
            $password = $('input[name=password]');
            $confirmPassword = $('input[name=confirmpassword]');
            let $checkOldPassword = false;
            let $checkPassword = false;

            if ($oldPassword.val() == ''){
                $oldPassword.addClass('is-invalid')
                $("#errorOldPassword").text("Trường này không được để trống") 
                $checkOldPassword = false
            } else if($oldPassword.val().length < 8 ){
                $oldPassword.addClass('is-invalid')
                $("#errorOldPassword").text("Trường này phải lớn hơn hoặc bằng 8 kí tự")
                $checkOldPassword = false
            } else {
                $oldPassword.removeClass('is-invalid')
                $("#errorOldPassword").text("")
                $checkOldPassword = true
            }

            if ($password.val() == ''){
                $password.addClass('is-invalid')
                $("#errorPassword").text("Trường này không được để trống")
                $checkPassword = false
            } else if ($password.val().length < 8 ){
                $password.addClass('is-invalid')
                $("#errorPassword").text("Trường này phải lớn hơn hoặc bằng 8 kí tự")
                $checkPassword = false
            } else {
                $password.removeClass('is-invalid')
                $("#errorPassword").text("")
                if ($confirmPassword.val() != $password.val()){
                $confirmPassword.addClass('is-invalid')
                $("#errorConfirmPassword").text("Mật khẩu không khớp")
                $checkPassword = false
                } else {
                    $confirmPassword.removeClass('is-invalid')
                    $("#errorConfirmPassword").text("")
                    $checkPassword = true
                }
            }
            if ($checkOldPassword == true && $checkPassword == true){
                $('form').submit();
            }
        })
    })
</script>
@endpush