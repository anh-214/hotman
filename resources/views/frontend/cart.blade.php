@extends('frontend.layouts.app')
@section('title')
    Giỏ hàng
@endsection

@section('content')
   <!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>Sản phẩm</th>
								<th>Tên</th>
								<th class="text-center">Giá</th>
								<th class="text-center">Số lượng</th>
								<th class="text-center">Tổng</th> 
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody class="tbody-cart">
						</tbody>
					</table>
					<input type="hidden" id="temp-input-number">
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li>Tổng giỏ hàng<span class="total-amount-all"></span></li>
										<li class="ship-type"></li>
										<li class="last">Bạn phải trả<span></span></li>
									</ul>
									<div class="button5">
										<a href="{{url('cart/checkout')}}" class="btn">Thanh toán</a>
										<a href="{{url('home')}}" class="btn">Tiếp tục mua hàng</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
			
	<!-- Start Shop Services Area  -->
	<section class="shop-services section">
		<div class="container pb-4">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Miễn phí ship</h4>
						<p>Cho đơn trên 500,000 đ</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Miễn phí hoàn trả</h4>
						<p>Trong 7 ngày</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Bảo mật thanh toán</h4>
						<p>100% bảo bật thanh toán</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Giá tốt nhất </h4>
						<p>Đảm bảo giá</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
	
@endsection
@push('js')
    <script>
        $(document).ready(function(){
			$(document).on('click','.remove-one-type',function(){
                let cart_id = $(this).attr('data-cart-id')
                // console.log(cart_id)
                let storageCart = JSON.parse(localStorage.getItem('cart'));
                cart = storageCart.filter(cart => cart.cart_id !== cart_id );
                localStorage.setItem('cart', JSON.stringify(cart));
                pull_cart();
            })
			pull_cart();
			$(document).on('click','.btn-number', function(e){
				e.preventDefault();
				fieldName = $(this).attr('data-field');
				type      = $(this).attr('data-type');
				var input = $("input[name='"+fieldName+"']");
				var currentVal = parseInt(input.val());
				cart_id = input.attr('cart-id')
				// alert(cart_id)
				if (!isNaN(currentVal)) {
					if(type == 'minus') {
						if(currentVal > input.attr('data-min')) {
							input.val(currentVal - 1).change();
							// update localstorage
							cart = JSON.parse(localStorage.getItem('cart'));
							cart.forEach(element => {
								if (element['cart_id'] == cart_id ){
									element['quantity'] -= 1 ;
								}
							});
							localStorage.setItem('cart', JSON.stringify(cart));
							refresh_cart();
							pull_cart()
							// 
						} 
						if(parseInt(input.val()) == input.attr('data-min')) {
							$(this).attr('disabled', true);
						}
					} else if(type == 'plus') {
						if(currentVal < input.attr('data-max')) {
							input.val(currentVal + 1).change();
							// console.log(currentVal+1)
							// update localstorage
							cart = JSON.parse(localStorage.getItem('cart'));
							cart.forEach(element => {
								if (element['cart_id'] == cart_id ){
									element['quantity'] = currentVal + 1 ;
								}
							});
							localStorage.setItem('cart', JSON.stringify(cart));
							refresh_cart();
							pull_cart()
							// 
						}
						if(parseInt(input.val()) == input.attr('data-max')) {
							$(this).attr('disabled', true);
						}
					}
				} else {
					input.val(0);
				}
			});
			$(document).on('focusin','.input-number',function(){
				$(this).attr('oldValue',$(this).val());
			});
			$(document).on('keydown','.input-number',function(e){
				minValue =  parseInt($(this).attr('data-min'));
				maxValue =  parseInt($(this).attr('data-max'));
				valueCurrent = parseInt($(this).val());
				name = $(this).attr('name');

				if ($.inArray(e.keyCode, [13]) !== -1){
					if (valueCurrent>maxValue){
						// alert('Giá trị vượt số lượng cho phép')
						valueCurrent = $(this).attr('oldValue');
					}
					if (valueCurrent <minValue){
						// alert('Giá trị thấp hơn số lượng cho phép')
						valueCurrent = $(this).attr('oldValue');
					}
					cart_id = $(this).attr('cart-id')
					cart = JSON.parse(localStorage.getItem('cart'));
					cart.forEach(element => {
						if (element['cart_id'] == cart_id ){
							element['quantity'] = valueCurrent ;
						}
					});
					localStorage.setItem('cart', JSON.stringify(cart));
					refresh_cart();
					pull_cart()
				}
			})
			
			$(document).on('change','.input-number',function() {
				minValue =  parseInt($(this).attr('data-min'));
				maxValue =  parseInt($(this).attr('data-max'));
				valueCurrent = parseInt($(this).val());
				name = $(this).attr('name');

				if(valueCurrent >= minValue) {
					$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
				} else {
					alert('Sorry, the minimum value was reached');
					$(this).val($(this).attr('oldValue'));
				}
				if(valueCurrent <= maxValue) {
					$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
				} else {
					alert('Sorry, the maximum value was reached');
					$(this).val($(this).attr('oldValue'));
					
				}
			});
			$('.input-number').keydown(function (e) {
					// Allow: backspace, delete, tab, escape, enter and .
					if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
						// Allow: Ctrl+A
						(e.keyCode == 65 && e.ctrlKey === true) || 
						// Allow: home, end, left, right
						(e.keyCode >= 35 && e.keyCode <= 39)) {
							// let it happen, don't do anything
							return;
					}
					// Ensure that it is a number and stop the keypress
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
						// alert('ahah')
					}
			});
			

        })
    </script>
@endpush