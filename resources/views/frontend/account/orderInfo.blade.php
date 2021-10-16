@extends('frontend.layouts.app')
@section('title')
    Chi tiết đơn hàng
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
                                        <div class="row">
                                                @php $total = 0; @endphp
                                                @foreach ($order->details as $detail)
                                                    @php 
                                                        $total += $detail->quantity*$detail->price
                                                    @endphp
                                                    <div class="col-md-12 mb-2">
                                                        <div class="card card-body border card-plain border-radius-lg d-flex">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <img class="" src="{{$detail->images[0]->name}}" alt="logo">
                                                                </div>
                                                                <div class="col-9">
                                                                    <a href="{{url('type/'.$detail->id)}}">
                                                                        <h6 class="m-0">{{$detail->name}}</h6>
                                                                    </a>
                                                                    <p class="m-0">Mã sản phẩm: {{$detail->id}}</p>
                                                                    <p class="m-0">Số lượng: {{$detail->quantity}}</p>
                                                                    <p class="m-0">Giá 1 sản phẩm: {{number_format($detail->price)}} đ</p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-main mb-4">
                                    <p class="m-0">Trạng thái: <span style="color: @if($order->status == 'Đơn rủi ro') {{'red'}} @else {{'green'}} @endif;">{{$order->status}}</span></p>
                                        
                                        @if ($order->confirmed_at == null && $order->deleted_at == null && $order->problem == null)
                                            <button class="btn mt-4" data-toggle="modal" data-target="#problemModal">Hủy đơn</button>
                                        @endif
                                   
                            </div>
                            <div class="form-main">
                                <p class="m-0">Tổng đơn hàng: <span>{{number_format($total)}} đ</span></p>
                                <p class="m-0">Phí giao hàng: <span>@php if($total<500000){$total += 30000; echo('30,000 đ');}else {
                                    echo('Freeship');
                                } @endphp</span></p>
                                <p class="m-0 h6">Phải thanh toán: <span class="h5">{{number_format($total)}} đ</span></p>
                                <p class="h6">Địa chỉ giao hàng</p>
                                <p class="m-0">{{$order->province->name}}</p>
                                <p class="m-0">{{$order->district->name}}</p>
                                <p class="m-0">{{$order->ward->name}}</p>
                                <p class="m-0">Chi tiết: {{$order->details_address}}</p>
                                <div>    
                            </div>
                        </div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End change Password -->
    </div>

{{-- modal --}}
<div class="modal fade" id="problemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width:40%">
        <div class="modal-content">
            {{-- <div class="modal-header float-left">
            <h5 class="modal-title" id="exampleModalLabel">Lý do hủy đơn hàng</h5>
            </div> --}}
            <div class="modal-body p-4" style="height: 50%;">
            <form>
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Mô tả lý do hủy đơn hàng:</h6></label>
                    <textarea type="text" class="form-control" name="desc"></textarea>
                    <div class="invalid-feedback" id="errorDesc">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="delete">Xác nhận hủy đơn </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            @if ($order->confirmed_at == null)
            $('#delete').click(function(){
                if ($('textarea[name=desc]').val() == ''){
                    $('textarea[name=desc]').addClass('is-invalid')
                    $('#errorDesc').text('Vui lòng không để trống trường này')
                } else {
                    $('textarea[name=desc]').removeClass('is-invalid')
                    $('#errorDesc').text('')
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/user/orders/delete",
                        data: {"_token": "{{ csrf_token() }}", 'id': '{{$order->id}}','desc': $('textarea[name=desc]').val()},
                        success: function(data){
                            if (data.result == 'success'){
                                window.location.reload()
                            }
                        
                        }
                    })
                }
            })
            $('#problemModal').on('hidden.bs.modal', function (event) {
                $('textarea[name=desc]').removeClass('is-invalid')
                $('#errorDesc').text('')
            })
            @endif
        })
    </script>
@endpush