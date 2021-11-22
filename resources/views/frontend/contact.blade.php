@extends('frontend.layouts.app')
@section('title')
    Liên hệ với chúng tôi
@endsection

@section('content')
    <div class="js">
    <!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Liên hệ với chúng tôi</h4>
									<h3>Điền vào form bên dưới</h3>
								</div>
								<form id="formSupport" class="form" method="POST">
									@csrf
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Tên của bạn<span>*</span></label>
												<input class="form-control" name="name" type="text" placeholder="" required>
												<div class="invalid-feedback" id="errorName">
													Vui lòng không để trống trường này
												</div>
											</div>
										</div>
										
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email của bạn<span>*</span></label>
												<input class="form-control" name="email" type="email" placeholder="">
												<div class="invalid-feedback" id="errorEmail">
												</div>
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Số điện thoại của bạn<span>*</span></label>
												<input class="form-control" name="phonenumber" type="text" placeholder="">
												<div class="invalid-feedback" id="errorPhoneNumber">
												</div>
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>Lời nhắn<span>*</span></label>
												<textarea class="form-control" name="content" placeholder=""></textarea>
												<div class="invalid-feedback" id="errorContent">
													Vui lòng không để trống trường này
												</div>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="button" id="send" class="btn">Gửi</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Hotline:</h4>
									<ul>
										<li>+84869967421</li>
										
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:info@yourwebsite.com">contact@hotman.com</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Địa chỉ:</h4>
									<ul>
										<li>69 Hồ Tùng Mậu, Mai Dịch, Cầu Giấy.</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	<!-- Map Section -->
	<div class="map-section">	
            <iframe id="myMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.9081887244583!2d105.77596551532766!3d21.036359292893827!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b596c44ea5%3A0x553bf130196da5c6!2zNjkgxJAuIEjhu5MgVMO5bmcgTeG6rXUsIE1haSBE4buLY2gsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1632149285201!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
	</div>
	<!--/ End Map Section -->
	
	<!-- Start Shop Newsletter  -->
	@include('frontend.layouts._subcriber')

	<!-- End Shop Newsletter -->
    </div>
@endsection
@push('js')
	<script>
		$(document).ready(function(){
			$('#send').click(function(){
				$count = 0;
				$email = $('input[name=email]');
				$name = $('input[name=name]');
        		$phonenumber = $('input[name=phonenumber]');
        		$content = $('textarea[name=content]');
				let $regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        		let $regexPhone = /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/

				if ($name.val() == ''){
					$name.addClass('is-invalid')
				} else {
					$name.removeClass('is-invalid')
					$count += 1
				}
				if ($email.val() == ''){
					$email.addClass('is-invalid')
					$("#errorEmail").text("Trường này không được để trống")
					
				} else if ($regexEmail.test($email.val()) == false){
					$email.addClass('is-invalid')
					$("#errorEmail").text("Nhập đúng định dạng email")
					
				} else {
					$email.removeClass('is-invalid')
					$("#errorEmail").text("")
					$count += 1
				}
				if ($phonenumber.val() == ''){
					$phonenumber.addClass('is-invalid')
					$("#errorPhoneNumber").text("Trường này không được để trống")
					
				} else if ($regexPhone.test($phonenumber.val()) == false){
					$phonenumber.addClass('is-invalid')
					$("#errorPhoneNumber").text("Nhập đúng định dạng số điện thoại")
					
				} else {
					$phonenumber.removeClass('is-invalid')
					$("#errorPhoneNumber").text("")
					$count +=1
				}
				if ($content.val() == ''){
					$content.addClass('is-invalid')
				} else {
					$content.removeClass('is-invalid')
					$count += 1
				}
				if ($count == 4){
					$('#formSupport').submit()
				}
			})
		})
	</script>
@endpush