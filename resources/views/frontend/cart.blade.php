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
						<tbody>
                            @php $total = 0;@endphp
                            @foreach ($cart as $id => $details)
                                @php $total += $details['price'] * $details['quantity'];@endphp
                                <tr>
                                    <td class="image" data-title="No"><img src="{{$details['image']}}" alt="#"></td>
                                    <td class="product-des" data-title="Description">
                                        <p class="product-name"><a href="{{$details['link']}}">{{$details['name']}}</a></p>
                                        <p class="product-des">Size: {{$details['size']}}</p>
                                    </td>
                                    <td class="price" data-title="Price"><span>{{number_format($details['price'])}} đ</span></td>
                                    <td class="qty" data-title="Qty"><!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number"  data-type="minus" data-field="quant[{{$details['id']}}]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" id_cart = "{{$id}}" name="quant[{{$details['id']}}]" class="input-number"  data-min="1" data-max="100" value="{{$details['quantity']}}">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$details['id']}}]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </td>
                                    <td class="total-amount" data-title="Total"><span>{{number_format($details['price'] * $details['quantity'])}} đ</span></td>
                                    <td data-id="{{$id}}" class="action remove" data-title="Remove"><a href="#"><i class="ti-trash remove-icon"></i></a></td>
                                </tr>
                            @endforeach
						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
								{{-- <div class="left">
									<div class="coupon">
										<form action="#" target="_blank">
											<input name="Coupon" placeholder="Enter Your Coupon">
											<button class="btn">Apply</button>
										</form>
									</div>
									<div class="checkbox">
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (+10$)</label>
									</div>
								</div> --}}
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li>Tổng giỏ hàng<span>{{number_format($total)}} đ</span></li>
                                        @if ($total >= 500000)
										    <li>Giao hàng toàn quốc<span>Miễn phí</span></li>
                                        @elseif ($total != 0)
                                            @php $total += 30000 @endphp
                                            <li>Giao hàng toàn quốc<span>30,000 đ</span></li>
                                        @endif
										{{-- <li>You Save<span>$20.00</span></li> --}}
										<li class="last">Bạn phải trả<span>{{number_format($total)}} đ</span></li>
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
            $('.input-number').change(function() {
                valueCurrent = parseInt($(this).val());
                id = $(this).attr('id_cart')
                $.ajax({
					type: "POST",
					dataType: "json",
					url: "{{url('update-cart')}}",
					data: {"_token": "{{ csrf_token() }}", 'id': id, 'quantity': valueCurrent},
					success: function(data){
						if (data.result == 'success'){
							window.location.reload()
						}
					}
				})
            })
        })
    </script>
@endpush