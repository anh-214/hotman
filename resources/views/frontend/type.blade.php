@extends('frontend.layouts.app')
@section('title')
    Liên hệ với chúng tôi
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
                                                        $images = \App\Models\Type::findOrFail($type_info->id)->images()->get()

                                                    @endphp
                                                    @foreach ($images as $image)
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
                                                            {{-- <option selected="selected">s</option>
                                                            <option>m</option>
                                                            <option>l</option>
                                                            <option>xl</option> --}}
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
                                                <a id="addToCart" data-id="{{$type_info->id}}" class="btn" style="cursor: pointer;">Thêm vào giỏ hàng</a>
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
			</div>
	</section>
	<!--/ End Contact -->
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
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            $('#addToCart').click(function(){
            let id = $(this).attr('data-id');
            let size = $('#select-size').val()
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
            $('.remove').click(function(){
            let id = $(this).attr('data-id');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{url('remove-from-cart')}}",
                    data: {"_token": "{{ csrf_token() }}", 'id': id},
                    success: function(data){
                        if (data.result == 'success'){
                            window.location.reload()
                        }
                    }
                })
	        })
        });
    </script>
@endpush