@extends('backend.layouts.app')

@section('title')
    Chi tiết loại sản phẩm
@endsection
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Chi tiết loại sản phẩm</h6>
                    <a href="{{url('admin/types')}}">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body pt-0 pb-2 mx-2">
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                </div>
                <div class="card-body px-0 pt-0 pb-4 mx-2">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <!-- start Product slider -->
                            <div id="carouselExampleControls" class="carousel slide mx-2" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($type->images as $image)
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
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" style="color: black" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" style="color: black" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                            </div>
                        <!-- End Product slider -->
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <div class="quickview-peragraph">
                                    <div class="mb-2">
                                        <span style="font-weight:bold">ID:</span>
                                        <span>{{$type->id}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Tên loại sản phẩm:</span>
                                        <span>{{$type->name}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Giá gốc:</span>
                                        <span>{{number_format($type->initial_price)}} đ</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Giá bán ra:</span>
                                        <span>{{number_format($type->price)}} đ</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Kiểu dáng:</span>
                                        <span>{{$type->designs}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Chi tiết:</span>
                                        <span>{{$type->details}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Chất liệu:</span>
                                        <span>{{$type->material}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Màu sắc:</span>
                                        <span>{{$type->color}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Sizes:</span>
                                        <span>{{$type->sizes}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Thuộc loại sản phẩm:</span>
                                        <a href="{{url('admin/products?id='.$type->product->id)}}">
                                            <span>{{$type->product->name}}</span>
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Chương trình khuyến mãi:</span>
                                        @isset($type->promotion->name)
                                        <a href="{{url('admin/promotions/'.$type->promotion->id)}}">
                                            <span>{{$type->promotion->name}}</span>
                                        </a>
                                        @else
                                            <span>Không</span>
                                        @endisset
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Thời gian tạo:</span>
                                        <span>{{$type->created_at}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span style="font-weight:bold">Thời gian cập nhật:</span>
                                        <span>{{$type->updated_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
    <style>
        .modal-footer{
            border-top: 0px;
            padding-bottom: 0px
        }
        .modal-body{
            padding-bottom: 0px

        }
    </style>
@endpush
