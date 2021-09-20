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
                    <h6>{{$select}}</h6>
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
                        <form method="POST" id="createForm" action="{{url('admin/types/upload')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="type_id" value="{{$type->id}}">
                                @foreach ($colors as $color)
                                    <label>{{$color}}</label>
                                @php
                                    $color = str_replace(" ","-",$color);
                                @endphp
                                    <input type="file" class="form-control" name="{{$type->id.'-'.$color.'[]'}}" multiple>
                                    <input type="text" class="form-control my-1" placeholder="Chèn link để thêm ảnh từ nguồn bên ngoài, cách nhau bằng dấu phẩy" name="{{'link-'.$type->id.'-'.$color}}">
                                @endforeach
                                
                            </div>
                            <div class="d-flex flex-row-reverse">
                                <button type="submit" id="btnCreate" class="btn btn-primary">Thêm ảnh</button>
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
    });
</script>
@endpush