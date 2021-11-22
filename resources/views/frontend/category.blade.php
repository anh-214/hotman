@extends('frontend.layouts.app')
@section('title')
    Trang thể loại
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
										@foreach ($category_info->products as $product_info)
											<li><a href="{{url('products/'.$product_info->id)}}">{{$product_info->name}}</a></li>
										@endforeach
									</ul>
								</div>
						</div>
					</div>
					<div class="col-lg-9 col-md-8 col-12">
						<div class="row">
							<div class="col-12">
								<!-- Shop Top -->
								<div class="shop-top">
									<div class="shop-shorter">
										<div class="single-shorter">
											<label>Hiện :</label>
											<select id="show_paginate">
												<option value="9" @if($paginate == 9) {{'selected'}} @endif>09</option>
												<option value="15" @if($paginate == 15) {{'selected'}} @endif>15</option>
												<option value="25" @if($paginate == 25) {{'selected'}} @endif>25</option>
												<option value="30" @if($paginate == 30) {{'selected'}} @endif>30</option>
											</select>
										</div>
										<div class="single-shorter">
											<label>Sắp xếp theo :</label>
											<select id="select_price">
												<option value="none" @if($sort_by_price == 'none') {{'selected'}} @endif>Không</option>
												<option value="asc" @if($sort_by_price == 'asc') {{'selected'}} @endif>Giá tăng dần</option>
												<option value="desc" @if($sort_by_price == 'desc') {{'selected'}} @endif>Giá giảm dần</option>
											</select>
										</div>
									</div>
									{{-- <ul class="view-mode">
										<li class="active"><a href="shop-grid.html"><i class="fa fa-th-large"></i></a></li>
										<li><a href="shop-list.html"><i class="fa fa-th-list"></i></a></li>
									</ul> --}}
								</div>
								<!--/ End Shop Top -->
							</div>
						</div>
						<div class="row">
						
							@foreach ($types as  $type)
							<div class="col-lg-4 col-md-6 col-12">
								<div class="single-product">
									<div class="product-img">
										<a href="{{url('types/'.$type->id)}}">
											<img class="default-img" src="@php
												if (filter_var($type->images[0]->name, FILTER_VALIDATE_URL)) { 
													echo($type->images[0]->name);
												} else {
													echo(Storage::disk('type-image')->url($type->images[0]->name));
												}   
												@endphp" alt="#">
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
										<h3><a href="{{url('types/'.$type->id)}}">{{$type->name}}</a></h3>
										<div class="product-price">
											@if($type->initial_price != $type->price)
											<span class="old">{{number_format($type->initial_price)}}đ</span>
											@endif
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
	@include('frontend.layouts._subcriber')
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
                                                    {{-- <option selected>Chọn size</option> --}}
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
                                    </div>
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
		} else {
			if (url.includes('?')){
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
		if (url.includes('?page=')){
			url = url.replace(regex_page,'');
			url = url.replace('page=','');
		} else if (url.includes('&page=')){
			url = url.replace(regex_page,'');
			url = url.replace('&page=','');
		}
		if ($select_price == 'none'){
			if (url.includes('?search=')){
				url = url.replace(regex_price,'');
				url = url.replace('&price=','')
			} else if (url.includes('&search=')){
				url = url.replace(regex_price,'');
				url = url.replace('price=','')
				url = url.replace('&','')
			} else if (url.includes('&paginate=')){
				url = url.replace(regex_price,'');
				url = url.replace('price=','')
				url = url.replace('&','')
			} else if (url.includes('?paginate=')){
				url = url.replace(regex_price,'');
				url = url.replace('&price=','')
			} else {
				url = url.replace(regex_price,'');
				url = url.replace('?price=','')
			}
			window.location.assign(url)
		} else 
		{	
			if (regex_price.test(url)){
				url = url.replace(regex_price,$select_price)
			} else {
				if (url.includes('?search=')){
					url = url + '&price=' + $select_price
				} else if (url.includes('?paginate=')){
					url = url + '&price=' + $select_price
				}
				else {
					url = url + '?price=' + $select_price
				}
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
			url: "{{url('products/getimages')}}",
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
			url: "{{url('products/quickshop')}}",
			data: {"_token": "{{ csrf_token() }}", 'id': id},
			success: function(data){
				let sizes = data.sizes.split(",")
				$count = 1
				$('#select-size').append(`<option selected>Chọn size</option>`)
				$('#size-color div ul').append(`<li data-value="Chọn size" class="option selected focus">Chọn size</li>`)
				$('#size-color div span').text('Chọn size')

				sizes.forEach(element => {
					$('#select-size').append(`<option>`+element.toUpperCase()+`</option>`)
					
					if ($count == 1) {
						$('#size-color div ul').append(`<li data-value="`+element.toUpperCase()+`" class="option">`+element.toUpperCase()+`</li>`)
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
				$('#addToCart').attr('data-price',data.price)
				$('#addToCart').attr('data-name',data.name)
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
		modal.find('#size-color div ul').empty()
		$(".carousel-inner").empty()
		$('#select-size').removeClass('is-invalid')
		$('#errorSize').text('')
		$('.input-number').val(1);
	});
	$('#addToCart').click(function(){
		let size = $('#select-size').val()
		if (size == 'Chọn size'){
			$('#errorSize').text('Vui lòng chọn size')
		} else {
			$('#errorSize').text('')

			let id = $(this).attr('data-id');
			function ajax1(){
				return $.ajax({
						type: "POST",
						dataType: "json",
						url: "{{url('/get-type-info')}}",
						data: {"_token": "{{ csrf_token() }}", 'id': id},
						success: function(data_ajax){
							return data_ajax
						}
				});
			}
			$.when(ajax1()).done(function(data){
				let quantity = $('.input-number').val()
				let update = false
				let cart = []
				if(localStorage.getItem('cart')){
					cart = JSON.parse(localStorage.getItem('cart'));
					cart.forEach(element => {
						if (element['cart_id'] == id+'-'+size){
							update = true
							element['quantity'] += parseInt(quantity);
						}
					});
				}
				if (update == false){
					cart.push({ 'cart_id' : id+'-'+size ,'id': id,'name': data.name, 'size': size, 'quantity': parseInt(quantity), 'price': parseInt(data.price), 'image' : data.image, 'link': data.link });
				}
				localStorage.setItem('cart', JSON.stringify(cart));
				refresh_cart();
				toastr.options.fadeOut = 2000;
				toastr.success("Đã thêm sản phẩm vào giỏ hàng");
				$('#quickShopModal').modal('hide')
			})
		}
		
	})


})
</script>
@endpush