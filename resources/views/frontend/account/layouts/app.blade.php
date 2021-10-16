<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Document')</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('backend/assets/images/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{ asset('backend/assets/images/favicon.png')}}">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('backend/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('backend/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('backend/assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('link')
    @stack('css')
</head>
<body>
<div class="g-sidenav-show  bg-gray-100">

    {{-- <!-- Navbar -->
    <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
        <div class="container">
        
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
            <ul class="navbar-nav navbar-nav-hover mx-auto">
            <li class="nav-item dropdown dropdown-hover mx-2">
                <a role="button" class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center " id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                Trang chủ
                </a>
            </li>
            <li class="nav-item dropdown dropdown-hover mx-2">
                <a role="button" class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center " id="dropdownMenuAccount" data-bs-toggle="dropdown" aria-expanded="false">
                Về chúng tôi
                </a>
            </li>
            <li class="nav-item dropdown dropdown-hover mx-2">
                <a role="button" href="{{url('/contact')}}" class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center " >
                Liên hệ
                </a>
            </li>
            </ul>
            <ul class="navbar-nav d-lg-block d-none">
            
            </ul>
        </div>
        </div>
    </nav> --}}
    @yield('content')
    @include('frontend.account.layouts._footer')
</div>
    <script src="{{asset('backend/assets/js/core/popper.min.js') }}"></script>
    <script src="{{asset('backend/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{asset('backend/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{asset('backend/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('backend/assets/js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
		$(document).ready(function(){
			@if(session()->has('success'))
				toastr.options.fadeOut = 2000;
				toastr.success("{{session('success')}}");
			@endif
			@if(session()->has('fail'))
				toastr.options.fadeOut = 2000;
				toastr.error("{{session('fail')}}");
			@endif
		})
	</script>
    @stack('js')
</body>
</html>






