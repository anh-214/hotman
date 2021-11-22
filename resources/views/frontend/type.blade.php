@extends('frontend.layouts.app')
@section('title')
    Chi tiết sản phẩm
@endsection
@push('css')
    <style>
        .quickview-peragraph p{
            margin-top: 10px!important
        }
    </style>
@endpush
@section('content')
    <div class="js">
    <!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-12 col-12">
							<div class="form-main">

                                <div class="row no-gutters">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- start Product slider -->
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($type_info->images as $image)
                                                        @php
                                                        if (filter_var($image->name, FILTER_VALIDATE_URL)) { 
                                                            $image = $image->name;
                                                        } else {
                                                            $link = Storage::disk('type-image')->url($image->name);
                                                            $image = $link;
                                                        }   
                                                        @endphp
                                                        @if ($count == 1)
                                                            <div class="carousel-item active">
                                                                <img class="d-block w-100" src="{{$image}}" alt="slide {{$count}}">
                                                            </div>
                                                        @else 
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100" src="{{$image}}" alt="slide {{$count}}">
                                                        </div>
                                                        @endif
                                                        @php $count +=1 @endphp
                                                    @endforeach
                                                    
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
                                            <h2 id="name">{{$type_info->name}}</h2>
                                            <div class="d-flex align-items-center">
                                                <h3 class="my-0 py-0">{{number_format($type_info->price).' đ'}}</h3>
                                                @if($type_info->price != $type_info->initial_price)
                                                    <p class="ml-2 py-0 my-0" style="color: red;text-decoration:line-through">{{number_format($type_info->initial_price).' đ'}}</p>
                                                @endif
                                            </div>
                                            <div class="quickview-peragraph">
                                                <p style="font-weight:bold">Kiểu dáng:</p>
                                                <p id="designs">{{$type_info->designs}}</p>
                                                <p style="font-weight:bold">Chi tiết:</p>
                                                <p id="details">{{$type_info->details}}</p>
                                                <p style="font-weight:bold">Chất liệu:</p>
                                                <p id="material">{{$type_info->material}}</p>
                                            </div>
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12" id="size-color">
                                                        <h5 class="title">Size</h5>
                                                        <select class="form-select" id="select-size">
                                                            <option selected>Chọn size</option>
                                                            @php $sizes = explode(',',$type_info->sizes) @endphp
                                                            @foreach ($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="errorSize" style="color: red">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <h5 id="color" class="title">Color: {{$type_info->color}}</h5>
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
                                                <a id="addToCart" data-id="{{$type_info->id}}" data-price="{{$type_info->price}}" data-name="{{$type_info->name}}" class="btn" style="cursor: pointer;">Thêm vào giỏ hàng</a>
                                               
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                 
                            
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	<!-- Start Shop Newsletter  -->
    @include('frontend.layouts._subcriber')
	<!-- End Shop Newsletter -->
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            
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
                        toastr.options.fadeOut = 2000;
				        toastr.success("Đã thêm sản phẩm vào giỏ hàng");
                        refresh_cart();
                    })
                }
		
	})
        });
    </script>
@endpush