<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('backend/assets/images/apple-icon.png')}}"> --}}
    <link rel="icon" type="image/png" href="{{ asset('backend/assets/images/faviconHotMan.png')}}">
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
    <style>
        body {
            overflow: hidden; /* Hide scrollbars */
            
        }
        .notification-count {
            position: absolute;
            top: -7px;
            right: -8px;
            background: #f6931d;
            width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            color: #fff;
            border-radius: 100%;
            font-size: 11px;
        }
        .hint-text{
            width: 7em; /* the element needs a fixed width (in px, em, %, etc) */
            overflow: hidden; /* make sure it hides the content that overflows */
            white-space: nowrap; /* don't break the line */
            text-overflow: ellipsis; /* give the beautiful '...' effect */
            margin: auto
        }
    </style>
</head>
<body class="g-sidenav-show  bg-gray-100">
    @include('backend.layouts._sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        @include('backend.layouts._header')
        @yield('content')
        @include('backend.layouts._footer')
    </main>
    
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="{{asset('backend/assets/js/core/popper.min.js') }}"></script>
    <script src="{{asset('backend/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{asset('backend/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{asset('backend/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('backend/assets/js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        $(document).ready(function(){
            $('#btnSearch').click(function(){
                $('#formSearch').submit()
            })
            @if(Auth::guard('admin')->check())

                Echo.channel('orderNotification')
                    .listen('MessageNotification', (e) => {
                        $count = $('.notification-count').text();
                        if ($count == ''){
                            $count = '0';
                        }
                        $count = parseInt($count) + 1
                        $('.notification-count').text($count);
                        $('.notification-count').show()

                        $('#dropdownNotification').prepend(`<li class="mb-2">
                                                <a class="dropdown-item border-radius-md" href="`+e.link+`">
                                                <div class="d-flex py-1">
                                                    <div class="my-auto">
                                                    <img src="`+e.image+`" class="avatar avatar-sm  me-3 ">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">`+e.message+`</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        <i class="fa fa-clock me-1"></i>
                                                        0 giây trước
                                                    </p>
                                                    </div>
                                                </div>
                                                </a>
                                            </li>`)
                        $subdays = $('#subdays option:selected').val();
                        $.ajax({
                                type: "GET",
                                dataType: "json",
                                url: "/admin/dashboard/getchart",
                                data: {"_token": "{{ csrf_token() }} ", 'subdays' : $subdays},
                        }).done(function(response){
                            var x = Object.keys(response['all']);
                            var y1 = Object.values(response['all']);
                            var y2 = Object.values(response['problems']);

                            myChart.data.datasets[0].data = y1;
                            myChart.data.datasets[1].data = y2;
                            myChart.data.labels = x;
                            myChart.update();
                            $('#total_all').text(parseInt(response['total_all']).toLocaleString('it-IT')+' đ')
                            $('#total_real').text(parseInt(response['total_real']).toLocaleString('it-IT')+' đ')
                            $('#count_orders').text(response['count_orders'])
                            $('#count_problems').text(response['count_problems'])
                        });
                });
            @endif
			@if(session()->has('success'))
				toastr.options.fadeOut = 2000;
				toastr.success("{{session('success')}}");
			@endif
			@if(session()->has('fail'))
				toastr.options.fadeOut = 2000;
				toastr.error("{{session('fail')}}");
			@endif
		})
        // $('.sidenav').attr('data-color','dark')
        // $('.sidenav').removeClass('bg-transparent')
        // $('.sidenav').addClass('bg-white')
        // $('.navbar').addClass(' blur shadow-blur mt-4 left-auto top-1 z-index-sticky')
       
    </script>
    
    @stack('js')
</body>
</html>






