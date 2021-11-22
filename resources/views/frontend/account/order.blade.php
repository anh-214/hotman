@extends('frontend.layouts.app')
@section('title')
    Quản lý đơn hàng
@endsection
@push('css')
    <style>
      
    </style>
@endpush

@push('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>    
@endpush

@section('content')
    <div class="js">
    <!-- Start changePassword -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="form-main">
                                <div class="title">
                                    <h4 class="mb-4">Quản lý đơn hàng</h4>
                                    <div> 
                                        @php $count = 0 @endphp
                                        @foreach ($orders as $order)
                                        @php $count+=1 @endphp
                                        <a href="{{url('user/orders/'.$order->id)}}">
                                            <div class="order p-3 mb-5">
                                                @php   
                                                    if ($order->checkout_status == 0){
                                                        $checkout_status=  'Chưa thanh toán';
                                                    };
                                                    if ($order->checkout_status == 1){
                                                        $checkout_status=  'Đã thanh toán ';
                                                    };
                                                    if ($order->checkout_status == 2){
                                                        $checkout_status=  'Lỗi thanh toán';
                                                    };
                                                @endphp
                                                <p class="m-0">Mã đơn hàng: {{$order->id}}</p>
                                                <p class="m-0">Trạng thái: <span style="color: @if($order->status == 'Đơn rủi ro') {{'red'}} @else {{'green'}} @endif;">{{$order->status}}</span></p>
                                                <p class="m-0">Phương thức thanh toán: {{strtoupper($order->payment_type)}}</p>
                                                <p class="m-0">Trạng thái thanh toán: <span style="color: @if($order->checkout_status == 1 ) {{'green'}} @else {{'red'}} @endif;">{{$checkout_status}}</span></p>
                                                <p class="m-0">Thời gian đặt: {{$order->created_at_converted}}</p>
                                            </div>
                                        </a>
                                        @endforeach
                                        @if ($count == 0)
                                            <p class="h6">Bạn không có đơn hàng nào</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End change Password -->
    </div>


@endsection
@push('js')
@endpush