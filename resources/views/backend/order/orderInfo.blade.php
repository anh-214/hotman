@extends('backend.layouts.app')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('content')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-xl-5 mb-4">
                <div class="card">
                    <div class="border-radius-xl" >
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <h5>Thông tin khách hàng</h5>
                                    <div class="mb-2">
                                        <span>Họ tên: {{$order->user->name}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span>Số điện thoại: {{$order->user->phonenumber}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span>Email: {{$order->user->email}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <h5>Địa chỉ</h5>
                                    <div class="mb-2">
                                        <span>{{$order->province->name}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span>{{$order->district->name}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span>{{$order->ward->name}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span>Chi tiết: {{$order->details_address}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="far fa-clock"></i>
                            </div>
                            </div>
                            <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Thời gian đặt</h6>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0">{{$order->created_at_converted}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                <i class="fas fa-wallet"></i>
                            </div>
                            </div>
                            <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">Tổng đơn hàng</h6>
                            {{-- <span class="text-xs">Belong Interactive</span> --}}
                            <hr class="horizontal dark my-3">
                            @php $total = 0 @endphp
                            @foreach ($order->details as $detail)
                                @php $total += $detail->quantity * intval($detail->price) @endphp
                            @endforeach
                            <h5 class="mb-0">{{number_format($total)}} đ</h5>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="col-xl-3 mb-4">
                <div class="card">
                    <div class="card-body p-4 pb-0 mb-3">
                        <div class="row">
                            <div class="col-xl-12 mb-4 pl-2">
                                <div class="mb-2">
                                    <h6>Phương thức thanh toán: {{strtoupper($order->payment_type)}}</h6>
                                    <h6>Trạng thái thanh toán: 
                                        @php   
                                            if ($order->checkout_status == 0){
                                                echo 'Chưa thanh toán';
                                            };
                                            if ($order->checkout_status == 1){
                                                echo 'Đã thanh toán';
                                            };
                                            if ($order->checkout_status == 2){
                                                echo 'Lỗi thanh toán';
                                            };
                                        @endphp
                                    </h6>
                                    <h6 class="mb-0">Tình trạng đơn hàng</h6>
                                </div>
                                @if($order->confirmed_at == null && $order->deleted_at == null)
                                    <div>
                                        <i class="fas fa-times-circle" style="color: red"></i>
                                        <span class="text-bolder">Chờ xác nhận</span>
                                    </div>
                                @elseif($order->deleted_at == null)
                                    <div>
                                        <i class="fas fa-check-circle" style="color: green"></i>
                                        <span class="text-bolder">Đã xác nhận: {{$order->confirmed_at}}</span>
                                    </div>
                                    @if ($order->start_deliver_at != null)
                                        <div>
                                            <i class="fas fa-check-circle" style="color: green"></i>
                                            <span class="text-bolder">Bắt đầu giao: {{$order->start_deliver_at}}</span>
                                        </div>
                                        @if($order->delivered_at != null)
                                            <div>
                                                <i class="fas fa-check-circle" style="color: green"></i>
                                                <span class="text-bolder">Đã giao: {{$order->delivered_at}}</span>
                                            </div>
                                        @endif
                                        @if($order->problem != null)
                                            <div>
                                                <i class="fas fa-times-circle" style="color: red"></i>
                                                <span class="text-bolder">Rủi ro: {{$order->problem}}</span>
                                            </div>
                                        @endif
                                    @endif
                                @elseif ($order->problem != null && $order->deleted_at != null && $order->confirmed_at == null)
                                    <div>
                                        <i class="fas fa-times-circle" style="color: red"></i>
                                        <span class="text-bolder">Khách hủy đơn với lý do: {{$order->problem}}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-xl-12">
                                <div class="row">
                                    @if($order->deleted_at != null)
                                    @elseif($order->confirmed_at == null)
                                            <div class="col-12 ">
                                                <button class="btn btn-success btn-sm mb-0" id="confirm">Xác nhận đơn hàng</button>
                                            </div>
                                    @else 
                                        @if ($order->start_deliver_at == null && $order->deleted_at == null)
                                            <div class="col-12 mb-2">
                                                <button class="btn btn-success btn-sm mb-0" id="start_deliver">Xác nhận giao cho bên vận chuyển</button>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-danger btn-sm mb-0" id="unconfirm">Hủy xác nhận đơn hàng</button>
                                            </div>
                                        @else
                                            @if($order->delivered_at == null && $order->problem == null)
                                                <div class="col-12 mb-2">
                                                    <button class="btn btn-success btn-sm mb-0" id="delivered">Xác nhận đã giao xong</button>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#problemModal">Đơn xảy ra rủi ro</button>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-12 mb-lg-0 mb-4">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Chi tiết đơn hàng</h6>
                        </div>
                        {{-- <div class="col-6 text-end">
                        <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Card</a>
                        </div> --}}
                    </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            @foreach ($order->details as $detail)
                                <div class="col-md-12 mb-2">
                                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                        <img class="w-10 me-3 mb-0" src="{{$detail->images[0]->name}}" alt="logo">
                                        <div>
                                            <h6 class="mb-0">{{$detail->name}}</h6>
                                            <p class="mb-0">Mã sản phẩm: {{$detail->id}}</p>
                                            <p class="mb-0">Số lượng: {{$detail->quantity}}</p>
                                            <p>Giá 1 sản phẩm: {{number_format($detail->price)}} đ</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{{-- modal --}}
<div class="modal fade" id="problemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rùi ro đơn hàng gặp phải</h5>
            </div>
            <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Mô tả:</h6></label>
                    <input type="text" class="form-control" name="desc">
                    <div class="invalid-feedback" id="errorDesc">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="problem">Xác nhận</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function(){
            @if ($order->confirmed_at == null && $order->deleted_at == null)
            $('#confirm').click(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/orders/{{$order->id}}/confirm",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(data){
                        if (data.result == 'success'){
                            window.location.reload()
                        }
                    
                    }
                })
            })
            @elseif ($order->confirmed_at != null && $order->start_deliver_at == null)
            $('#unconfirm').click(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/orders/{{$order->id}}/unconfirm",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(data){
                        if (data.result == 'success'){
                            window.location.reload()
                        }
                    
                    }
                })
            })
            $('#start_deliver').click(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/orders/{{$order->id}}/start_deliver",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(data){
                        if (data.result == 'success'){
                            window.location.reload()
                        }
                    
                    }
                })
            })
            @endif
            @if ($order->start_deliver_at != null && $order->delivered_at == null && $order->problem == null)
            $('#delivered').click(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/orders/{{$order->id}}/delivered",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(data){
                        if (data.result == 'success'){
                            window.location.reload()
                        }
                    
                    }
                })
            })
            $('#problem').click(function(){
                if ($('input[name=desc]').val() == ''){
                    $('input[name=desc]').addClass('is-invalid')
                    $('#errorDesc').text('Vui lòng không để trống trường này')
                } else {
                    $('input[name=desc]').removeClass('is-invalid')
                    $('#errorDesc').text('')
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/admin/orders/{{$order->id}}/problem",
                        data: {"_token": "{{ csrf_token() }}",'problem': $('input[name=desc]').val()},
                        success: function(data){
                            if (data.result == 'success'){
                                window.location.reload()
                            }
                        
                        }
                    })
                }
            })
            @endif
        })
    </script>
@endpush