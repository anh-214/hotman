@extends('backend.layouts.app')

@section('title')
    Quản lí đơn hàng
@endsection

@section('content')
<div class="container-fluid py-4">

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3 py-2">
                    <h6 class="text-center mb-0">@php echo ($displayTime == '') ? 'Tất cả các ngày' : $displayTime @endphp</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card mb-2">
                    <div class="card-header text-center pt-1">
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Doanh thu tạm tính</h6>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{number_format($total_all)}} đ</h5>
                    </div>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="card mb-2">
                    <div class="card-header text-center pt-1">
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Doanh thu thực (Đã hoàn thành)</h6>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{number_format($total_real)}} đ</h5>
                    </div>
                </div>
            </div>  
            <div class="col-md-3">
                <div class="card mb-2">
                    <div class="card-header text-center pt-1">
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Tổng số đơn</h6>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{$count_orders}}</h5>
                    </div>
                </div>
            </div>  
            <div class="col-md-3">
                <div class="card mb-2">
                    <div class="card-header text-center pt-1">
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Đơn rủi ro - bị hủy</h6>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{$count_problems}}</h5>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="col-md-7 mt-2">
        <div class="card">
            <div class="card-header pb-0 px-3">
            <h6 class="mb-0">Đơn hàng</h6>
            </div>
            <div class="card-body pt-4 p-3">
            <ul class="list-group">
                @foreach ($orders as $order )
                    <li class="list-group-item border-0 d-flex  mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Khách hàng: {{$order->user->name}}</h6>
                            <span class="mb-2 text-xs">Trạng thái: 
                                @php 
                                    if ($order->confirmed_at == null){
                                        $status = 'Chưa xác nhận';
                                    };
                                    if ($order->confirmed_at != null) {
                                        $status = 'Đã xác nhận';
                                    };
                                    if ($order->start_deliver_at != null) {
                                        $status = 'Đang giao';
                                    };
                                    if ($order->delivered_at != null) {
                                        $status = 'Đã giao xong';
                                        
                                    };
                                    if ($order->problem != null) {
                                        $status = 'Đơn rủi ro';
                                    }
                                @endphp
                                @if ($status == 'Đơn rủi ro' || $status == 'Chưa xác nhận' )
                                    <span class="ms-sm-2 font-weight-bold" style="color: red">{{$status}}</span>
                                @else
                                    <span class="ms-sm-2 font-weight-bold" style="color: green">{{$status}}</span>
                                @endif
                            </span>
                            <span class="mb-2 text-xs">Trạng thái thanh toán: 
                                <span class="ms-sm-2 font-weight-bold" style="color: @if($order->checkout_status == 1 ) {{'green'}} @else {{'red'}} @endif;">
                                @php   
                                    if ($order->checkout_status == 0){
                                        echo 'Chưa thanh toán';
                                    };
                                    if ($order->checkout_status == 1){
                                        echo 'Đã thanh toán ';
                                    };
                                    if ($order->checkout_status == 2){
                                        echo 'Lỗi thanh toán';
                                    };
                                @endphp
                                </span>
                            </span> 
                            <span class="mb-2 text-xs">Thời gian tạo: <span class="text-dark ms-sm-2 font-weight-bold">{{$order->created_at_converted}}</span></span>
                            <span class="mb-2 text-xs">Tổng đơn hàng: <span class="text-dark ms-sm-2 font-weight-bold">{{number_format($order->total)}} đ</span></span>
                        </div>
                        <div class="ms-auto text-end">
                            <a class="btn btn-link text-primary text-gradient px-3 mb-0" href="{{url('admin/orders/'.$order->id)}}"><i class="fas fa-eye"></i>  Xem chi tiết</a>
                            {{-- <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a> --}}
                        </div>
                    </li>
                @endforeach
            </ul>
            </div>
        </div>
    </div>
    <div class="col-md-5 mt-2">
        <div class="card mb-4 col-12">
            <div class="card-header pb-0 px-3">
            <div class="row">
                <div class="col-md-6">
                    <a class="mb-0" href="{{url('admin/orders')}}"><button class="btn btn-primary m-0">Tất cả các ngày</button></a>
                    {{-- <h6 class="mb-0">Lọc đơn theo ngày : @php echo ($time != '') ? $time : 'Tất cả các ngày' @endphp</h6> --}}
                </div>
            </div>
            </div>
            <div class="card-body pt-4 p-3" id="calendar">
            </div>
        </div>
    </div>

</div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script>
    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            // events: SITEURL + "/calendar-event",
            displayEventTime: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (event_start, event_end, allDay) {
                    var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD");
                    var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD");
                    url = "{{url('admin/orders/date')}}/"+event_start+'/'+event_end
                    window.location.assign(url)  
            },
        });
        @if($from != '')
            $(".fc-today").addClass("fc-past")
            $(".fc-today").removeClass("fc-today")
            // calendar.select( '{{$from}}', '{{$to}}')
            @php 
                $a = explode('-',$from);
                $b = explode('-',$to);
                $dd = intval($b[2]);
                if ($dd == 1){
                    $dd = 32;
                }
            @endphp
            @for($i = intval($a[2]);$i < $dd;$i++)
                @if ($i<10)
                    $("td[data-date='{{$a[0]}}-{{$a[1]}}-0{{$i}}']").addClass("fc-today")
                @else
                    $("td[data-date='{{$a[0]}}-{{$a[1]}}-{{$i}}']").addClass("fc-today")
                @endif
                
            @endfor
        @endif
    });
</script>
@endpush