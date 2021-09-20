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
								<form class="form" method="post" action="mail/mail.php">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Tên của bạn<span>*</span></label>
												<input name="name" type="text" placeholder="">
											</div>
										</div>
										
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email của bạn<span>*</span></label>
												<input name="email" type="email" placeholder="">
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Số điện thoại của bạn<span>*</span></label>
												<input name="company_name" type="text" placeholder="">
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>Lời nhắn<span>*</span></label>
												<textarea name="message" placeholder=""></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Gửi</button>
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
										<li><a href="mailto:info@yourwebsite.com">info@ahihi.com</a></li>
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
	<section class="shop-newsletter section">
		<div class="container">
			<div class="inner-top">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 col-12">
						<!-- Start Newsletter Inner -->
						<div class="inner">
							<h4>Thông báo mới</h4>
							<p> Đăng ký nhận tin </p>
							<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
								<input name="EMAIL" placeholder="Địa chỉ email của bạn" required="" type="email">
								<button class="btn">Đăng ký</button>
							</form>
						</div>
						<!-- End Newsletter Inner -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
    </div>
@endsection