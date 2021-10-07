@extends('backend.layouts.app')

@section('title')
    Quản lí ảnh sản phẩm
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Cập nhật loại sản phẩm</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0">
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive px-3">
                        <form method="POST" id="createForm" action="{{url('admin/types/update')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$type->id}}">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" class="form-control" name="nameType" value="{{$type->name}}">
                                <div class="invalid-feedback" id="errorName">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Thuộc thể loại</label>
                                <select id="category_id" class="form-control" name="category_id" > 
                                    <option>Chọn ...</option>
                                    @foreach ($categories as $category )
                                        <option value="{{$category->id}}" @if ($category->id == $oldCategoryId) {{'selected'}} @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="errorCategoryId">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Thuộc sản phẩm</label>
                                <select id="product_id" name="product_id" class="form-control">
                                    @foreach ($oldProducts as $oldProduct)
                                        <option value="{{$oldProduct->id}}" @if ($oldProduct->id == $oldProductId) {{'selected'}} @endif>{{$oldProduct->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Giá khuyến mại</label>
                                    <input type="number" class="form-control" name="priceType" placeholder="Nếu không có khuyến mại, vui lòng để trống ô này" value="{{$type->price}}">
                                    <div class="invalid-feedback" id="errorPrice">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Giá gốc</label>
                                    <input type="number" class="form-control" name="initialPriceType" placeholder="Giá gốc của sản phẩm" value="{{$type->initial_price}}">
                                    <div class="invalid-feedback" id="errorInitialPrice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Sizes</label>
                                    <input type="text" class="form-control" name="sizesType" placeholder="Nhập size cách nhau bằng dấu phẩy, VD: x,m,l" value="{{$type->sizes}}">
                                    <div class="invalid-feedback" id="errorSizes">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Màu sắc</label>
                                    <input type="text" class="form-control" name="colorType" placeholder="Nhập màu sắc cách nhau bằng dấu phẩy, VD: xanh đậm,xám khói" value="{{$type->color}}">
                                    <div class="invalid-feedback" id="errorColors">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Thêm ảnh loại sản phẩm</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/png, image/jpeg">
                                <div class="invalid-feedback" id="errorImages">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Thêm ảnh loại sản phẩm bằng đường link (Nếu có)</label>
                                <input type="text" class="form-control my-1" placeholder="Chèn link để thêm ảnh từ nguồn bên ngoài, cách nhau bằng dấu phẩy" name="linkImages">
                                <div class="invalid-feedback" id="errorLinkImages">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kiểu dáng</label>
                                <textarea type="text" class="form-control" name="designsType">{{$type->designs}}</textarea>
                                <div class="invalid-feedback" id="errorDesigns">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chi tiết sản phẩm</label>
                                <textarea type="text" class="form-control" name="detailsType">{{$type->details}}</textarea>
                                <div class="invalid-feedback" id="errorDetails">
                                </div>
                            </div>
                           
                            <div class="form-group col-md-12">
                                <label>Chất liệu</label>
                                <textarea type="text" class="form-control" name="materialType">{{$type->material}}</textarea>
                                <div class="invalid-feedback" id="errorMaterial">
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse">
                                <button type="button" id="btnCreate" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
<script>
    $(document).ready(function(){
        $('#category_id').change(function(){
                let select = document.getElementById("product_id");
                let length = select.options.length;
                for (i = length-1; i >= 0; i--) {
                    select.options[i] = null;
                }
                let $category_id = $(this).val();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/types/getProductId",
                    data: {"_token": "{{ csrf_token() }}", 'category_id': $category_id},
                    success: function(data){
                        data.forEach(element => {
                            addOption(element.id,element.name)
                        });
                    }
                });
        })
        function addOption(id,name){
            $("#product_id").append(new Option(name, id));
        }

        // validation
        $('#btnCreate').click(function(){
            let count = 0
            if ($("input[name=nameType]").val() == ''){
                $("input[name=nameType]").addClass('is-invalid')
                $("#errorName").text('Vui lòng không để trống trường này')
            } else {
                $("input[name=nameType]").removeClass('is-invalid')
                $("#errorName").text('')
                count += 1
            }

            if ($("input[name=initialPriceType]").val() == ''){
                $("input[name=initialPriceType]").addClass('is-invalid')
                $("#errorInitialPrice").text('Vui lòng không để trống trường này')
            } else {
                $("input[name=initialPriceType]").removeClass('is-invalid')
                $("#errorInitialPrice").text('')
                count += 1
                if ($("input[name=priceType]").val() != ''){
                    if ( parseInt($("input[name=priceType]").val()) < parseInt($("input[name=initialPriceType]").val())){           
                        $("input[name=priceType]").removeClass('is-invalid')
                        $("#errorPrice").text('')
                    } else {
                        $("input[name=priceType]").addClass('is-invalid')
                        $("#errorPrice").text('Giá khuyến mại phải nhỏ hơn giá gốc')
                        count -= 1
                    }
                }
            }

            if ($("input[name=sizesType]").val() == ''){
                $("input[name=sizesType]").addClass('is-invalid')
                $("#errorSizes").text('Vui lòng không để trống trường này')
            } else {
                let sizes = $("input[name=sizesType]").val()
                let checkSize = true
                sizes = sizes.split(",")
                sizes.forEach(size => {
                    if (size == ''){
                        checkSize = false
                    } 
                });
                if (checkSize){
                    $("input[name=sizesType]").removeClass('is-invalid')
                    $("#errorSizes").text('')
                    count += 1
                } else {
                    $("input[name=sizesType]").addClass('is-invalid')
                    $("#errorSizes").text('Sai định dạng size')
                }
                
            }

            if ($("input[name=colorType]").val() == ''){
                $("input[name=colorType]").addClass('is-invalid')
                $("#errorColor").text('Vui lòng không để trống trường này')
            } else {
                $("input[name=colorType]").removeClass('is-invalid')
                $("#errorColor").text('')
                count += 1
            }

            if ($("#category_id").val() == 'Chọn ...'){
                $("#category_id").addClass('is-invalid')
                $("#errorCategoryId").text('Vui lòng không để trống trường này')
            } else {
                $("#category_id").removeClass('is-invalid')
                $("#errorCategoryId").text('')
                count += 1
            }
            if ($("textarea[name=designsType]").val() == ''){
                $("textarea[name=designsType]").addClass('is-invalid')
                $("#errorDesigns").text('Vui lòng không để trống trường này')
            } else {
                $("textarea[name=designsType]").removeClass('is-invalid')
                $("#errorDesigns").text('')
                count += 1
            }
            if ($('textarea[name=detailsType]').val() == ''){
                $("textarea[name=detailsType]").addClass('is-invalid')
                $("#errorDetails").text('Vui lòng không để trống trường này')
            } else {
                $("textarea[name=detailsType]").removeClass('is-invalid')
                $("#errorDetails").text('')
                count += 1
            }
            if ($('textarea[name=materialType]').val() == ''){
                $("textarea[name=materialType]").addClass('is-invalid')
                $("#errorMaterial").text('Vui lòng không để trống trường này')
            } else {
                $("textarea[name=materialType]").removeClass('is-invalid')
                $("#errorMaterial").text('')
                count += 1
            }
            if ($('input[name=linkImages]').val() != ''){
                let links = $("input[name=linkImages]").val()
                let checkLink = true
                links = links.split(",")
                links.forEach(link => {
                    console.log(link)
                    if (window.location.href.indexOf(link) > -1){
                        checkLink = false
                    } else {
                        checkLink = true
                    }
                });
                if (checkLink==false){
                    $("input[name=linkImages]").addClass('is-invalid')
                    $("#errorLinkImages").text('Vui lòng nhập đúng định dạng url') 
                } else {
                    $("input[name=linkImages]").removeClass('is-invalid')
                    $("#errorLinkImages").text('')
                }
            }
            if (count == 8){
                $("#createForm").submit();
            }
        
        })
    });
</script>
@endpush