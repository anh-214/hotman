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
	
	
</head>
<body>
    @include('frontend.layouts._header')
    @yield('content')
    @include('frontend.layouts._footer')
    <!-- Jquery -->
    <script src="{{asset('frontend/assets/js/jquery.min.js')}}"></script>
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
</body>
</html>