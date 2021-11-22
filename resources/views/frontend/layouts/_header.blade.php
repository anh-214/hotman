

		<header class="header shop">
			@php
			$headers = \App\Models\Homesort::where('role','header')->where('show','1')->orderBy('position','asc')->get();
			@endphp
			@foreach ($headers as $header)
				{!! $header->content !!}
			@endforeach
			{{-- <div class="preloader">
				<div class="preloader-inner">
					<div class="preloader-icon">
						<span></span>
						<span></span>
					</div>
				</div>
			</div> --}}
			<!-- Topbar -->
			{{-- <div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-12 col-12">
							<!-- Top Left -->
							<div class="top-left">
								<ul class="list-main">
									<li><i class="ti-headphone-alt"></i> +84 869967421</li>
									<li><i class="ti-email"></i> support@hotman.com</li>
								</ul>
							</div>
							<!--/ End Top Left -->
						</div>
						<div class="col-lg-8 col-md-12 col-12">
							<!-- Top Right -->
							<div class="right-content">
								<ul class="list-main">
									<li><i class="ti-location-pin"></i> Store location</li>
								</ul>
							</div>
							
						</div>
					</div>
				</div>
			</div> --}}
			<!-- End Topbar -->
			@if (Auth::check())
				@if (Auth::guard('web')->user()->phonenumber == null)
					<div class="alert alert-warning" role="alert">
						Vui lòng cập nhật thêm số điện thoại, <a style="color: black;font-weight:bold" href="{{url('/user/information')}}">nhấn vào đây</a>
					</div>
				@endif
			@endif
			<div class="middle-inner">
				<div class="container">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-12">
							<!-- Logo -->
							<div class="logo">
								<a href="{{url('/')}}"><img src="{{asset('backend/assets/images/logoHotMan.png')}}" alt="logo"></a>
							</div>
							<!--/ End Logo -->
							<!-- Search Form -->
							{{-- <div class="search-top">
								<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							</div> --}}
							<!--/ End Search Form -->
							<div class="mobile-nav"></div>
						</div>
						<div class="col-lg-8 col-md-7 col-12">
							<div class="search-bar-top">
								<div class="search-bar" style="position: relative">
									@php
										$categories = \App\Models\Category::with('products')->get();
									@endphp
									<select id="selectSearch">
										<option selected="selected" value="all">Tất cả</option>
										@foreach ($categories as $category)
											<option value="{{$category->id}}">{{$category->name}}</option>	
										@endforeach
									</select>
									<form method="GET" action="{{url('types')}}" autocomplete="off">
										<input type="hidden" name="select" value="all">
										<input name="search" placeholder="Tìm kiếm sản phẩm tại đây" type="text" id="search" value="@isset($search){{$search}}@endisset" required>
										<button class="btnn"><i class="ti-search"></i></button>
									</form>
									<div class="mt-2 p-2 bg-light" id="resultSearch">
										<ul>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-3 col-12">
							<div class="right-bar">
								
								<div class="sinlge-bar user">
									<a href="#" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
									{{--user --}}
									<div class="shopping-user">
										@if (Auth::guard('web')->check())
											<div class="dropdown-user-header" style="text-align: left;">
												<p>
													Xin chào, <span>{{Auth::guard('web')->user()->name}}</span>
												</p>
												<img src="
												@if (filter_var(Auth::guard('web')->user()->avatar, FILTER_VALIDATE_URL))
													{{Auth::guard('web')->user()->avatar}}
												@else
													{{Storage::disk('user-avatar')->url(Auth::guard('web')->user()->avatar == null ? 'unknown.png' : Auth::guard('web')->user()->avatar)}}
												@endif
												" alt="">
											</div>
											<div class="dropdown-user-action">
												<p><a href="{{url('/user/information')}}">Thông tin tài khoản</a></p>
												<p><a href="{{url('/user/orders')}}">Quản lý đơn hàng</a></p>
												@if (Auth::guard('web')->user()->password_is_null == 'False')
													<p><a href="{{url('/user/changepassword')}}">Đổi mật khẩu</a></p>
												@endif
												@if (Auth::guard('web')->user()->password_is_null == 'True')
													<p id="showModalConfirmCreatePassword" style="cursor: pointer;">Tạo mật khẩu (Không bắt buộc)</p>
												@endif
												<a href="{{url('/user/logout')}}" style="color: #F7941D">Đăng xuất</a>
											</div>
										@else
											<div class="dropdown-user-header">
												<a href="{{url('/user/login')}}" type="button" class="btn btn-primary">Đăng nhập</a>
											</div>
											<div class="dropdown-user-register">
												<span>Bạn chưa có tài khoản ?</span>
												<a href="{{url('/user/register')}}" >Đăng Ký</a>
											</div>
										@endif
									</div>
								</div>
								<div class="sinlge-bar shopping">
									<a href="#" class="single-icon"><i class="ti-bag"></i> <span class="cart-total-count"></span></a>
									<!-- Shopping Item -->
									<div class="shopping-item">
										<div class="dropdown-cart-header">
											<span></span>
										</div>
										<ul class="shopping-list">
										</ul>
										<div class="bottom">
											<div class="total">
												<span>Tổng</span>
												<span class="cart-total-amount"></span>
											</div>
											<a href="{{url('cart')}}" class="btn animate">Xem giỏ hàng</a>
										</div>
									</div>
									<!--/ End Shopping Item -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="cat-nav-head">
						<div class="row">
							<div class="col-12">
								<div class="menu-area">
									<!-- Main Menu -->
									<nav class="navbar navbar-expand-lg">
										<div class="navbar-collapse">	
											<div class="nav-inner">	
												<ul class="nav main-menu menu navbar-nav">
													<li @php if(isset($active) && $active == 'home') echo('class="active"');  @endphp><a href="{{url('/')}}">Trang chủ</a></li>
													<li @php if(isset($active) && $active == 'categories') echo('class="active"');  @endphp><a style="cursor: pointer">Sản phẩm<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															@foreach ($categories as $category)
																<li><a href="{{url('categories/'.$category->id)}}">{{$category->name}}<i class="ti-angle-down"></i></a>
																	<ul class="dropdown-child">
																		@foreach ($category->products as $product)
																			<li><a href="{{url('products/'.$product->id)}}">{{$product->name}}</a></li>																	
																		@endforeach
																		
																	</ul>
																</li>
															@endforeach
														</ul>
													</li>												
								
													<li @php if(isset($active) && $active == 'contact') echo('class="active"');  @endphp><a href="{{url('/contact')}}">Liên hệ</a></li>
												</ul>
											</div>
										</div>
									</nav>
									<!--/ End Main Menu -->	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!--/ End Header -->
	
	<!-- Breadcrumbs -->
	@isset($breadCrumbs)
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{url('/')}}">Trang chủ</a></li>
							@foreach ( $breadCrumbs as $breadCrumb )
								<li class=""><i class="ti-arrow-right"></i><a href="{{url($breadCrumb['link'])}}">{{$breadCrumb['name']}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endisset
	<!-- End Breadcrumbs -->
	{{-- toast --}}

