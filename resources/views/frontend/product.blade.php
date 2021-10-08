@extends('frontend.layouts.app')
@section('title')
    Trang sản phẩm
@endsection
@push('css')
	<style>
		.single-slider img{
			max-height: 450px;
		}
		.single-slider {
			text-align: center;
			max-height: 520px;
			align-items: center
		}
		.default-img{
			min-height: 350px;
		}
		#initial_price{
			text-decoration: line-through;
			margin-left: 20px;
			color: red

		}
	</style>
@endpush
@section('content')
<div class="js">

    <!-- Product Style -->
		<section class="product-area shop-sidebar shop section">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-12">
						<div class="shop-sidebar">
								<!-- Single Widget -->
								<div class="single-widget category">
									<h3 class="title">{{$category_info->name}}</h3>
									<ul class="categor-list">
										@foreach ($product_infos as $product_info)
											<li><a href="{{url('/category/'.$category_info->id.'/product/'.$product_info->id)}}">{{$product_info->name}}</a></li>
										@endforeach

									</ul>
								</div>
								<!--/ End Single Widget -->
								<!-- Shop By Price -->
								<div class="single-widget range">
									<h3 class="title">Shop by Price</h3>
									<div class="price-filter">
										<div class="price-filter-inner">
											<div id="slider-range"></div>
												<div class="price_slider_amount">
												<div class="label-input">
													<span>Range:</span><input type="text" id="amount" name="price" placeholder="Add Your Price"/>
												</div>
											</div>
										</div>
									</div>
									<ul class="check-box-list">
										<li>
											<label class="checkbox-inline" for="1"><input name="news" id="1" type="checkbox">$20 - $50<span class="count">(3)</span></label>
										</li>
										<li>
											<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">$50 - $100<span class="count">(5)</span></label>
										</li>
										<li>
											<label class="checkbox-inline" for="3"><input name="news" id="3" type="checkbox">$100 - $250<span class="count">(8)</span></label>
										</li>
									</ul>
								</div>
								<!--/ End Shop By Price -->
								<!-- Single Widget -->

								@isset($latest_types)
								<div class="single-widget recent-post">
									<h3 class="title">Sản phẩm mới</h3>
									{{-- @php $types = \App\Models\Category::where('id',$category_info->id)->first(); @endphp --}}
									<!-- Single Post -->
									@foreach ($latest_types as $latest_type)
									@php
										$latest_product = \App\Models\Product::where('id',$latest_type->product_id)->first();
									@endphp
										<div class="single-post first">
											<div class="image">
												<img src="@php
														$image = \App\Models\Image::where('type_id',$latest_type->id)->first();
														echo ($image->name);
													@endphp" alt="#">
											</div>
											<div class="content">
												<h5><a href="{{url('category/'.$category_info->id.'/product/'.$latest_product->id.'/type/'.$latest_type->id)}}">{{$latest_type->name}}</a></h5>
												<p class="price">{{number_format($latest_type->price).' đ'}}</p>
												{{-- <ul class="reviews">
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li><i class="ti-star"></i></li>
													<li><i class="ti-star"></i></li>
												</ul> --}}
											</div>
										</div>
									@endforeach

									<!-- End Single Post -->
									{{-- <!-- Single Post -->
										<div class="single-post first">
											<div class="image">
												<img src="https://via.placeholder.com/75x75" alt="#">
											</div>
											<div class="content">
												<h5><a href="#">Women Clothings</a></h5>
												<p class="price">$99.50</p>
												<ul class="reviews">
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li><i class="ti-star"></i></li>
												</ul>
											</div>
										</div>
										<!-- End Single Post -->
										<!-- Single Post -->
										<div class="single-post first">
											<div class="image">
												<img src="https://via.placeholder.com/75x75" alt="#">
											</div>
											<div class="content">
												<h5><a href="#">Man Tshirt</a></h5>
												<p class="price">$99.50</p>
												<ul class="reviews">
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
													<li class="yellow"><i class="ti-star"></i></li>
												</ul>
											</div>
										</div>
										<!-- End Single Post --> --}}
									</div>
									@endisset
									<!--/ End Single Widget -->
									{{-- <!-- Single Widget -->
								<div class="single-widget category">
									<h3 class="title"></h3>
									<ul class="categor-list">


									</ul>
								</div>
								<!--/ End Single Widget --> --}}
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-12">
						<div class="row">
							<div class="col-12">
								<!-- Shop Top -->
								<div class="shop-top">
									<div class="shop-shorter">
										<div class="single-shorter">
											<label>Show :</label>
											<select id="show_paginate">
												<option value="9" @if($paginate == 9) {{'selected'}} @endif>09</option>
												<option value="15" @if($paginate == 15) {{'selected'}} @endif>15</option>
												<option value="25" @if($paginate == 25) {{'selected'}} @endif>25</option>
												<option value="30" @if($paginate == 30) {{'selected'}} @endif>30</option>
											</select>
										</div>
										<div class="single-shorter">
											<label>Sort By :</label>
											<select id="select_price">
												<option @if($sort_by_price == 'none') {{'selected'}} @endif>None</option>
												<option value="asc" {{ $sort_by_price == 'asc' ? 'selected' : '' }}>Price Up</option>
												<option value="desc" {{ $sort_by_price == 'desc' ? 'selected' : '' }}>Price Down</option>
											</select>
										</div>
									</div>
									<ul class="view-mode">
										<li class="active"><a href="shop-grid.html"><i class="fa fa-th-large"></i></a></li>
										<li><a href="shop-list.html"><i class="fa fa-th-list"></i></a></li>
									</ul>
								</div>
								<!--/ End Shop Top -->
							</div>
						</div>
						<div class="row">
                            @foreach ($types as  $type)
							@php
								$product = \App\Models\Product::where('id',$type->product_id)->first();
							@endphp
							<div class="col-lg-4 col-md-6 col-12">
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{url('category/'.$category_info->id.'/product/'.$product->id.'/type/'.$type->id)}}">

                                            <img class="default-img" src="@php
												if (filter_var($type->images[0]->name, FILTER_VALIDATE_URL)) {
													echo($type->images[0]->name);
												} else {
													echo(Storage::disk('type-image')->url($type->images[0]->name));
												}
												@endphp" alt="#">
											{{-- <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#"> --}}
										</a>
										<div class="button-head">
                                            <div class="product-action">
                                                <a data-id= "{{$type->id}}" class="quickshop"><i class="ti-eye"></i><span>Quick Shop</span></a>
												{{-- <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
												<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a> --}}
											</div>
											{{-- <div class="product-action-2">
                                                <a title="Add to cart" href="{{url('add-to-cart/'.$type->id)}}">Add to cart</a>
											</div> --}}
										</div>
									</div>
									<div class="product-content">

                                        <h3><a href="{{url('category/'.$category_info->id.'/product/'.$product->id.'/type/'.$type->id)}}">{{$type->name}}</a></h3>
										<div class="product-price">
                                            <span>{{number_format($type->price).' đ'}}</span>
										</div>
									</div>
								</div>
							</div>
                            @endforeach
						</div>
						@isset($types)
							<div class="d-flex justify-content-center">{{$types->links('vendor.pagination.bootstrap-4')}}</div>
						@endisset
					</div>
				</div>
			</div>
		</section>

		<!--/ End Product Style 1  -->


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
    <!-- Modal -->
        <div class="modal fade" id="quickShopModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<!-- start Product slider -->
								<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner">
										</div>
										<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</a>
								</div>
							<!-- End Product slider -->
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="quickview-content">
                                    <h2 id="name"></h2>
									<div style="display: flex;align-items:center">
										<h3 id="price"></h3>
										<p id="initial_price"></p>
									</div>
                                    <div class="quickview-peragraph">
										<p style="font-weight:bold">Kiểu dáng:</p>
                                        <p id="designs"></p>
										<p style="font-weight:bold">Chi tiết:</p>
                                        <p id="details"></p>
										<p style="font-weight:bold">Chất liệu:</p>
                                        <p id="material"></p>
                                    </div>
                                    <div class="size">
                                        <div class="row">
                                            <div class="col-lg-12 col-12" id="size-color">
                                                <h5 class="title">Size</h5>
                                                <select class="form-select" id="select-size">
                                                    <option selected>Chọn size</option>
                                                    {{-- <option selected="selected">s</option>
                                                    <option>m</option>
                                                    <option>l</option>
                                                    <option>xl</option> --}}
                                                </select>
												<div id="errorSize" style="color: red">
												</div>
                                            </div>
                                            <div class="col-lg-12 col-12 mt-4">
                                                <h5 id="color" class="title">Color: </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="quantity">
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </div>
                                    <div class="add-to-cart">
                                        <a id="addToCart" class="btn" style="cursor: pointer;">Thêm vào giỏ hàng</a>
                                        {{-- <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                        <a href="#" class="btn min"><i class="fa fa-compress"></i></a> --}}
                                    </div>
                                    {{-- <div class="default-social">
                                        <h4 class="share-now">Share:</h4>
                                        <ul>
                                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<!-- Modal end -->
</div>
@endsection
@push('js')
{{-- data for delete modal boostrap --}}
<script>
$(document).ready(function(){
	let regex_paginate = /(?<=paginate=)(\w+)/
	let regex_price = /(?<=price=)(\w+)/
	let regex_page = /page=/

	$('#show_paginate').change(function(){
		$paginate = $(this).val();
		var url = window.location.href;
		if (regex_paginate.test(url)){
			url = url.replace(regex_paginate,$paginate)
			window.location.assign(url)
			// console.log(url)
		} else {
			if (regex_page.test(url)){
				url = url + '&paginate=' + $paginate
			} else {
				url = url + '?paginate=' + $paginate
			}
			window.location.assign(url)
		}
	})
	$('#select_price').change(function(){
		$select_price = $(this).val();
		var url = window.location.href;
		if (regex_price.test(url)){
			url = url.replace(regex_price,$select_price)
			window.location.assign(url)
		} else {
			if (regex_page.test(url)){
				url = url + '&price=' + $select_price
			} else if (regex_paginate.test(url)){
				url = url + '&price=' + $select_price
			} else {
				url = url + '?price=' + $select_price
			}
			window.location.assign(url)
		}
	})
    $('.quickshop').click(function (event) {
        let id = $(this).attr('data-id')
		$('#addToCart').attr('data-id',id)
		let modal = $('#quickShopModal')
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{url('product/getimages')}}",
			data: {"_token": "{{ csrf_token() }}", 'id': id},
			success: function(data){
				let count = 0;
				data.forEach(link => {
					if (count == 0){
						$(".carousel-inner").append(`<div class="carousel-item active">
													<img class="d-block w-100" src="`+link+`" alt="slide `+count+`">
												</div>`)
					} else {
						$(".carousel-inner").append(`<div class="carousel-item">
													<img class="d-block w-100" src="`+link+`" alt="slide `+count+`">
												</div>`)
					}
					count += 1;
				});
			}
		});
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "{{url('product/quickshop')}}",
			data: {"_token": "{{ csrf_token() }}", 'id': id},
			success: function(data){
				let sizes = data.sizes.split(",")
				$count = 1
				sizes.forEach(element => {
					$('#select-size').append(`<option>`+element.toUpperCase()+`</option>`)
					// addOption(element)
					if ($count == 1) {
						$('#size-color div ul').append(`<li data-value="`+element.toUpperCase()+`" class="option selected focus">`+element.toUpperCase()+`</li>`)
					} else {
						$('#size-color div ul').append(`<li data-value="`+element.toUpperCase()+`" class="option">`+element.toUpperCase()+`</li>`)
					}
					$count +=1
				});
				price = data.price
				initial_price = data.initial_price
				if (price == initial_price){
					modal.find('#price').text(parseInt(initial_price).toLocaleString('it-IT')+' đ')
				} else {
					modal.find('#price').text(parseInt(price).toLocaleString('it-IT')+' đ')
					modal.find('#initial_price').text(parseInt(initial_price).toLocaleString('it-IT')+' đ')
				}
				modal.find('#name').text(data.name)
				modal.find('#designs').text(data.designs)
				modal.find('#material').text(data.material)
				modal.find('#details').text(data.details)
				modal.find('#color').text('Color: '+data.color)
				// $("#size-color select").niceSelect();

			}
		});
		modal.modal('show')
    });

	$('#quickShopModal').on('hidden.bs.modal', function (event) {
		var modal = $(this)
		$('.quickview-slider-active').empty()
		modal.find('#price').text('')
		modal.find('#initial_price').text('')
		modal.find('#name').text('')
		modal.find('#color').text('')
		modal.find('#designs').text('')
		modal.find('#material').text('')
		modal.find('#details').text('')
		modal.find('#select-size').empty()
		$('#size-color div ul').empty()
		$(".carousel-inner").empty()
	});
	$('#addToCart').click(function(){
		let id = $(this).attr('data-id');
		let size = $('#select-size').val()
		// console.log(id)
		if (size == 'Chọn size'){
			$('#errorSize').text('Vui lòng chọn size')
		} else {
			$('#errorSize').text('')
			let quantity = $('.input-number').val()
			// console.log(quantity)
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "{{url('add-to-cart')}}",
				data: {"_token": "{{ csrf_token() }}", 'id': id, 'size': size, 'quantity': quantity},
				success: function(data){
					if (data.result == 'success'){
						window.location.reload()
					}
				}
			})
		}
	})
})
</script>
@endpush
