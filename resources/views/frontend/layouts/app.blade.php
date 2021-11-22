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
	<link rel="icon" type="image/png" href="{{asset('frontend/assets/images/faviconHotMan.png')}}">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- StyleSheet -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
	{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    @stack('link')
	@stack('css')
	<style>
		#resultSearch {
			position: absolute;
			top:100%;
			left:30%;
			z-index:9999;
			box-shadow: 10px 10px 10px #5c5b5b85;
			display:none
		}
		#resultSearch ul li a:hover {
			font-weight: bolder
		} 
		#resultSearch ul li div.col-9 {
			text-align: left
		}
	</style>
	
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
	{{-- <script src="{{asset('frontend/assets/js/colors.js')}}"></script> --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/color-js/1.0.1/color.js" integrity="sha512-zXHWlN+vi1A8FcoJN7NUprrM2pTph/b20Um9WeTfNF/2Fn0yeD8kzD+TMYRwhSuYTIzZwP4hkRaJNfGvM9rrAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
	<script src="{{asset('frontend/assets/js/cart-localstorage.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
	<script>
		$(document).ready(function(){
			@if(session()->has('success'))
				toastr.options.fadeOut = 2000;
				toastr.success("{{session('success')}}");
				localStorage.clear()
			@endif
			@if(session()->has('fail'))
				toastr.options.fadeOut = 2000;
				toastr.error("{{session('fail')}}");
			@endif
			$(document).on('click','.remove',function(){
				let regex = /checkout/
				let regex1 = /cart/
				let url = window.location.href
				// console.log(regex.test(url))
				if (regex.test(url) == false && regex1.test(url) == false){
					let cart_id = $(this).attr('data-cart-id')
					// console.log(cart_id)
					let storageCart = JSON.parse(localStorage.getItem('cart'));
					cart = storageCart.filter(cart => cart.cart_id !== cart_id );
					localStorage.setItem('cart', JSON.stringify(cart));
					refresh_cart()
					pull_cart()
				}

            })
			//  load cart
			refresh_cart()
			$('#search').on('keyup',function(){
                $value = $(this).val();
				$category_id = $('#selectSearch').val()
				if ($value != ''){
					$('#resultSearch').show();
					$.ajax({
						type: 'get',
						url: "{{url('search')}}",
						data: {
							'category_id': $category_id,
							'search': $value,
						},
						success:function(data){
							$('#resultSearch ul').html(data);
						}
					});
				} else {
					$('#resultSearch ul').html('');
					$('#resultSearch').hide();
				}
                
            })
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
			$('#selectSearch').change(function(){
				$select = $(this).val();
				$('.search-bar-top .search-bar form input[name=select]').val($select)
			})
		})
	</script>
	<!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
		var chatbox = document.getElementById('fb-customer-chat');
		chatbox.setAttribute("page_id", "101461992347860");
		chatbox.setAttribute("attribution", "biz_inbox");

		window.fbAsyncInit = function() {
			FB.init({
			xfbml            : true,
			version          : 'v12.0'
			});
		};

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    </script>
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
				<button type="button" class="btn btn-primary" onclick="window.location.assign('{{url('user/createpassword')}}')" >Tạo mật khẩu</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		
	$(document).ready(function(){
			$('#showModalConfirmCreatePassword').click(function(){
				$('#modalConfirmCreatePassword').modal('show')
			})
		})
	</script>
	@endif
	@endif


</body>
</html>