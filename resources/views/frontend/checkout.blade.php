@extends('frontend.layouts.app')
@section('title')
    Thanh toán
@endsection

@section('content')
<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-8 col-12">
                <div class="checkout-form">
                    {{-- <h2>Tiến hành thanh toán tại đây</h2> --}}
                    <p>Tiến hành nhập địa chỉ thanh toán tại đây</p>
                    <!-- Form -->
                    <form class="form needs-validation" method="POST" action="{{url('cart/checkout')}}" novalidate>
                        @csrf
                        <div class="row">
                            <input type="hidden" name="type_payment">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Họ và tên: <label style="font-weight:bolder;color:black">{{Auth::guard('web')->user()->name}}</label></label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Số điện thoại: <label style="font-weight:bolder;color:black" id="phonenumber">@if(Auth::guard('web')->user()->phonenumber == null) <a href="{{url('user/information')}}" style="color: red">Cập nhật số điện thoại</a> @else {{Auth::guard('web')->user()->phonenumber}} @endif</label></label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tỉnh / Thành phố<span>*</span></label>
                                    <select class="form-control" name="province" id="provinces" required>
                                        <option value="" selected="selected">Chọn ...</option>
                                        @foreach ($provinces as  $province)
                                            <option value="{{$province->id}}">{{$province->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="errorProvince">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Quận / Huyện<span>*</span></label>
                                    <select class="form-control" name="district" id="districts" required>
                                        <option value="" selected="selected">Chọn ...</option>
                                    </select>
                                    <div class="invalid-feedback" id="errorDistrict">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Xã / Phường<span>*</span></label>
                                    <select class="form-control" name="ward" id="wards" required>
                                        <option value="" selected="selected">Chọn ...</option>
                                    </select>
                                    <div class="invalid-feedback" id="errorWard">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cụ thể<span>*</span></label>
                                    <input class="form-control" type="text" name="detailsAddress" placeholder="Số nhà, tên đường, ..." required>
                                    <div class="invalid-feedback" id="errorDetails">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="order-details">
                    <!-- Order Widget -->
                    <div class="single-widget">
                        <h2>Tổng hóa đơn</h2>
                        <div class="content">
                            <ul>
                                <li class="total-amount-checkout">Tổng đơn hàng<span> đ</span></li>
                                <li>(+) Giao hàng<span class="type-ship-checkout"></span></li>
                                <li class="last">Tổng<span></span></li>
                            </ul>
                        </div>
                    </div>
                    <!--/ End Order Widget -->
                    <!-- Order Widget -->
                    <div class="single-widget">
                        <h2>Thanh toán</h2>
                        <div class="content">
                            <div class="checkbox">
                                <label class="checkbox-inline" for="1"><input name="payment" id="1" type="radio" value="cod" checked> Thanh toán khi nhận hàng (COD)</label>
                                <label class="checkbox-inline" for="2"><input name="payment" id="2" type="radio" value="online"> Thanh toán cổng thanh toán online</label>
                                {{-- <label class="checkbox-inline" for="3"><input name="payment" id="3" type="checkbox"> PayPal</label> --}}
                            </div>
                        </div>
                    </div>
                    <!--/ End Order Widget -->
                    <!-- Payment Method Widget -->
                    <div class="single-widget payement">
                        <div class="content">
                            <img src="{{asset('frontend/assets/images/payment-method.png')}}" alt="#">
                        </div>
                    </div>
                    <!--/ End Payment Method Widget -->
                    <!-- Button Widget -->
                    <div class="single-widget get-button">
                        <div class="content">
                            <div class="button">
                                <a class="btn" style="cursor: pointer" id="btnorder">Đặt hàng</a>
                            </div>
                        </div>
                    </div>
                    <!--/ End Button Widget -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Checkout -->

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
            $('#provinces').change(function(){
                let select = document.getElementById("districts");
                let length = select.options.length;
                for (i = length-1; i >= 0; i--) {
                    select.options[i] = null;
                }
                let select1 = document.getElementById("wards");
                let length1 = select1.options.length;
                for (i = length1-1; i >= 0; i--) {
                    select1.options[i] = null;
                }
                $("#districts").append(new Option('Chọn ...', ''));
                $("#wards").append(new Option('Chọn ...', ''));

                // nice select
                let $niceselect = $('#districts + div.nice-select ul.list')
                $niceselect.empty();
                $niceselect.append(`<li class='option selected'>Chọn ...</li>`)

                let $niceselect1 = $('#wards + div.nice-select ul.list')
                $niceselect1.empty();
                $niceselect1.append(`<li class='option selected'>Chọn ...</li>`)

                let $province_id = $(this).val();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/getdistricts",
                    data: {"_token": "{{ csrf_token() }}", 'province_id': $province_id},
                    success: function(data){
                        data.forEach(element => {
                            // addOption(element.id,element.name)
                            $("#districts").append(new Option(element.name, element.id));
                            $niceselect.append(`<li data-value="`+element.id+`" class='option'>`+element.name+`</li>`)
                        });
                    }
                });
            })
            $('#districts').change(function(){
                let select = document.getElementById("wards");
                let length = select.options.length;
                for (i = length-1; i >= 0; i--) {
                    select.options[i] = null;
                }
                $("#wards").append(new Option('Chọn ...', ''));

                let $niceselect = $('#wards + div.nice-select ul.list')
                $niceselect.empty();
                $niceselect.append(`<li class='option selected'>Chọn ...</li>`)
                let $district_id = $(this).val();

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/getwards",
                    data: {"_token": "{{ csrf_token() }}", 'district_id': $district_id},
                    success: function(data){
                        data.forEach(element => {
                            // addOption(element.id,element.name)
                            $("#wards").append(new Option(element.name, element.id));
                            $niceselect.append(`<li data-value="`+element.id+`" class='option'>`+element.name+`</li>`)
                        });
                    }
                });
            })
            $('#btnorder').click(function(){
                $detailAddress = $('input[name=detailsAddress]')
                let $province = $('#provinces')
                let $district = $('#districts')
                let $ward = $('#wards')
                let $phonenumber = $('#phonenumber').text();
                
                let $payment = $('input[name=payment]:checked')
                $('input[name=type_payment]').val($payment.val())
                $count = 0
                if ($province.val() == ''){
                    $province.addClass('is-invalid')
                    $("#errorProvince").text("Trường này không được để trống") 
                } else {
                    $province.removeClass('is-invalid')
                    $("#errorProvince").text("")
                    $count +=1
                }

                if ($district.val() == ''){
                    $district.addClass('is-invalid')
                    $("#errorDistrict").text("Trường này không được để trống") 
                } else {
                    $district.removeClass('is-invalid')
                    $("#errorDistrict").text("")
                    $count +=1
                }

                if ($ward.val() == ''){
                    $ward.addClass('is-invalid')
                    $("#errorWard").text("Trường này không được để trống") 
                } else {
                    $ward.removeClass('is-invalid')
                    $("#errorWard").text("")
                    $count +=1
                }

                if ($detailAddress.val() == ''){
                    $detailAddress.addClass('is-invalid')
                    $("#errorDetails").text("Trường này không được để trống") 
                } else {
                    $detailAddress.removeClass('is-invalid')
                    $("#errorDetails").text("")
                    $count +=1
                }
                if ($.isNumeric($phonenumber)){
                    // alert($phonenumber)
                    $count+=1
                }
                if ($count == 5){
                    cart = localStorage.getItem('cart');
                    let type_cart = $('input[name=payment]:checked').val()
                    // console.log(type_cart);
                    if (type_cart == 'cod'){
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: "{{url('cart/checkout/cod')}}",
                            data: {"_token": "{{ csrf_token() }}", 'cart': cart,'type_cart':type_cart, 'ward': $('select[name=ward]').val(), 'detailsAddress': $('input[name=detailsAddress]').val()},
                            success: function(data_ajax){
                                if (data_ajax.result == 'success'){
                                    localStorage.clear()
                                    window.location.assign("{{url('/')}}")
                                }
                            }
                        });
                    } else {
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: "{{url('cart/checkout/online')}}",
                            data: {"_token": "{{ csrf_token() }}", 'cart': cart,'type_cart':type_cart, 'ward': $('select[name=ward]').val(), 'detailsAddress': $('input[name=detailsAddress]').val()},
                            success: function(data_ajax){
                                // alert(data_ajax.link)
                                window.location.assign(data_ajax.link)
                                // if (data_ajax.result == 'success'){
                                    // localStorage.clear()
                                // }
                            }
                        });
                    }
                }
            })
            checkout()
        })
    </script>
@endpush