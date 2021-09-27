<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title>@yield('title','Document')</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="{{asset('frontend/assets/images/favicon.png')}}">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.css')}}">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/magnific-popup.min.css')}}">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/font-awesome.css')}}">
	<!-- Fancybox -->
	<link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.fancybox.min.css')}}">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/themify-icons.css')}}">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/niceselect.css')}}">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.css')}}">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/flex-slider.min.css')}}">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/owl-carousel.css')}}">
	<!-- Slicknav -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/slicknav.min.css')}}">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="{{asset('frontend/assets/css/reset.css')}}">
	<link rel="stylesheet" href="{{asset('frontend/assets/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/responsive.css')}}">
    @stack('link')
	@stack('css')
	
	
</head>
<body>
    @include('frontend.layouts._header')
    @yield('content')
    @include('frontend.layouts._footer')

    <!-- Jquery -->
    <script src="{{asset('frontend/assets/js/jquery.min.js')}}"></script>
	{{-- <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script> --}}

    <script src="{{asset('frontend/assets/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/assets/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/assets/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/assets/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/assets/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/assets/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/assets/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/assets/js/magnific-popup.js')}}"></script>
	<!-- Fancybox JS -->
	<script src="{{asset('frontend/assets/js/facnybox.min.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/assets/js/waypoints.min.js')}}"></script>
	<!-- Jquery Counterup JS -->
	<script src="{{asset('frontend/assets/js/jquery-counterup.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/assets/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/assets/js/nicesellect.js')}}"></script>
	<!-- Ytplayer JS -->
	<script src="{{asset('frontend/assets/js/ytplayer.min.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/assets/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/assets/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/assets/js/onepage-nav.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/assets/js/easing.js')}}"></script>
	<!-- Google Map JS -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnhgNBg6jrSuqhTeKKEFDWI0_5fZLx0vM"></script>	
	<script src="{{asset('frontend/assets/js/gmap.min.js')}}"></script>
	{{-- <script src="{{asset('frontend/assets/js/map-script.js')}}"></script> --}}
	<!-- Active JS -->
	<script src="{{asset('frontend/assets/js/active.js')}}"></script>
    @stack('js')
	@if (Auth::guard('web')->check())
	@if (Auth::guard('web')->user()->password_is_null == 'True')
	<div class="modal fade" id="modalConfirmCreatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document" style="width:50%;">
			<div class="modal-content">
				<div class="modal-body" style="padding:30px 0 30px 30px;height: 20%;">
				<h5 class="modal-title d-flex pt-2 pr-2">Thông báo</h5>
				<p>Bạn vẫn có thể đăng nhập bình thường bằng Google, Github, Facebook mà không cần mật khẩu</p>
				<p>Bạn vẫn muốn tạo mật khẩu chứ ? Mật khẩu mới sẽ được gửi về email của bạn</p>
				<p>Trong lần đăng nhập tiếp theo bạn có thể đăng nhập bằng email và mật khẩu hoặc dùng Google, Github, Facebook </p>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
				<button type="button" class="btn btn-primary" id="btnCreatePassword" >Tạo mật khẩu</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalResultCreatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document" style="width:50%;">
			<div class="modal-content">
				<div class="modal-body" style="padding:30px 0 30px 30px;height: 20%;">
				<h5 class="modal-title d-flex pt-2 pr-2">Thông báo</h5>
				<p>Chúng tôi đã gửi mật khẩu về email của bạn, Vui lòng kiểm tra email và tiến hành đăng nhập lại !</p>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick=" window.location.assign('{{url('user/login')}}') ">Thoát</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
				$('#showModalConfirmCreatePassword').click(function(){
					$('#modalConfirmCreatePassword').modal('show')
				})
				$('#btnCreatePassword').click(function(){
					$('#modalConfirmCreatePassword').modal('hide')
					$.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "/user/createpassword",
                            data: {"_token": "{{ csrf_token() }}", 'email': "{{Auth::guard('web')->user()->email}}"},
                            success: function(data){
                                if (data.result == 'sent'){
                                    $('#modalResultCreatePassword').modal('show')
                                }
                            }
                        });
				})
			})
	</script>
	@endif
	@endif


</body>
</html>