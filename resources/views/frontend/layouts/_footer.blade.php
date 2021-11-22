	<!-- Start Footer Area -->
	<footer class="footer">
		@php
		$footers = \App\Models\Homesort::where('role','footer')->where('show','1')->orderBy('position','asc')->get();
		@endphp
		@foreach ($footers as $footer)
			{!! $footer->content !!}
		@endforeach
		<!-- Footer Top -->
		{{-- <div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<a href="index.html"><img src="{{asset('backend/assets/images/logoHotMan1.png')}}" alt="#"></a>
							</div>
							<p class="text"></p>
							<p class="call">Hotline<span><a href="tel:123456789">+84869967421</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Thông tin</h4>
							<ul>
								<li><a href="{{url('contact')}}">Về chúng tôi</a></li>
								<li><a href="#">Faq</a></li>
								<li><a href="#">Điều khoản và điều kiện</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Giúp đỡ</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Liên lạc</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>69 Hồ Tùng Mậu.</li>
									
									<li>info@hotman.com</li>
									<li>+84869967421</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<ul>
								<li><a href="#"><i class="ti-facebook"></i></a></li>
								<li><a href="#"><i class="ti-twitter"></i></a></li>
								<li><a href="#"><i class="ti-flickr"></i></a></li>
								<li><a href="#"><i class="ti-instagram"></i></a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div> --}}
		<!-- End Footer Top -->
		{{-- <div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © 2021 <a href="https://www.facebook.com/Anh2k1/" target="_blank">Anh2k1</a>  -  All Rights Reserved.</p>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="right">
								<img src="{{asset('frontend/assets/images/payments.png')}}" alt="#">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
	</footer>
	<!-- /End Footer Area -->
	