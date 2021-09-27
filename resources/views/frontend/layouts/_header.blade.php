
{{-- <!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->
	 --}}
	
		
		<!-- Header -->
		<header class="header shop">
			{{-- <!-- Topbar -->
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-12 col-12">
							<!-- Top Left -->
							<div class="top-left">
								<ul class="list-main">
									<li><i class="ti-headphone-alt"></i> +060 (800) 801-582</li>
									<li><i class="ti-email"></i> support@shophub.com</li>
								</ul>
							</div>
							<!--/ End Top Left -->
						</div>
						<div class="col-lg-8 col-md-12 col-12">
							<!-- Top Right -->
							<div class="right-content">
								<ul class="list-main">
									<li><i class="ti-location-pin"></i> Store location</li>
									<li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li>
									<li><i class="ti-user"></i> <a href="#">My account</a></li>
									<li><i class="ti-power-off"></i><a href="login.html#">Login</a></li>
								</ul>
							</div>
							<!-- End Top Right -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Topbar --> --}}
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
								<a href="index.html"><img src="{{asset('backend/assets/images/logoHotMan.png')}}" alt="logo"></a>
							</div>
							<!--/ End Logo -->
							<!-- Search Form -->
							<div class="search-top">
								<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
								<!-- Search Form -->
								<div class="search-top">
									<form class="search-form">
										<input type="text" placeholder="Search here..." name="search">
										<button value="search" type="submit"><i class="ti-search"></i></button>
									</form>
								</div>
								<!--/ End Search Form -->
							</div>
							<!--/ End Search Form -->
							<div class="mobile-nav"></div>
						</div>
						<div class="col-lg-8 col-md-7 col-12">
							<div class="search-bar-top">
								<div class="search-bar">
									<select>
										<option selected="selected">All Category</option>
										<option>watch</option>
										<option>mobile</option>
										<option>kid’s item</option>
									</select>
									<form>
										<input name="search" placeholder="Search Products Here....." type="search">
										<button class="btnn"><i class="ti-search"></i></button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-3 col-12">
							<div class="right-bar">
								<!-- Search Form -->
								{{-- <div class="sinlge-bar">
									<a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
								</div> --}}
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
									<a href="#" class="single-icon"><i class="ti-bag"></i> <span class="total-count">2</span></a>
									<!-- Shopping Item -->
									<div class="shopping-item">
										<div class="dropdown-cart-header">
											<span>2 Items</span>
											<a href="#">View Cart</a>
										</div>
										<ul class="shopping-list">
											<li>
												<a href="#" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
												<a class="cart-img" href="#"><img src="https://via.placeholder.com/70x70" alt="#"></a>
												<h4><a href="#">Woman Ring</a></h4>
												<p class="quantity">1x - <span class="amount">$99.00</span></p>
											</li>
											<li>
												<a href="#" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
												<a class="cart-img" href="#"><img src="https://via.placeholder.com/70x70" alt="#"></a>
												<h4><a href="#">Woman Necklace</a></h4>
												<p class="quantity">1x - <span class="amount">$35.00</span></p>
											</li>
										</ul>
										<div class="bottom">
											<div class="total">
												<span>Total</span>
												<span class="total-amount">$134.00</span>
											</div>
											<a href="checkout.html" class="btn animate">Checkout</a>
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
													<li class="active"><a href="#">Home</a></li>
													<li><a href="#">Product</a></li>												
													<li><a href="#">Service</a></li>
													<li><a href="#">Shop<i class="ti-angle-down"></i><span class="new">New</span></a>
														<ul class="dropdown">
															<li><a href="shop-grid.html">Shop Grid</a></li>
															<li><a href="cart.html">Cart</a></li>
															<li><a href="checkout.html">Checkout</a></li>
														</ul>
													</li>
													<li><a href="#">Pages</a></li>									
													<li><a href="#">Blog<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															<li><a href="blog-single-sidebar.html">Blog Single Sidebar</a></li>
														</ul>
													</li>
													<li><a href="{{url('/contact')}}">Contact Us</a></li>
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
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{url('/home')}}">Home</a></li>
							@foreach ( $breadCrumbs as $breadCrumb )
								<li class=""><i class="ti-arrow-right"></i><a href="{{url($breadCrumb['link'])}}">{{$breadCrumb['name']}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
	{{-- toast --}}

