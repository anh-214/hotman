@extends('backend.layouts.app')

@section('title')
    Phản hồi khách hàng
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Phản hồi khách hàng : {{$support->name}}</h5>
                <a href="{{url('admin/supports')}}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="card-body">
                    <div class="mb-4">
                        <span>Email: {{$support->email}}</span>
                        @if ($support->status == 'false')
                        <a href="mailto:{{$support->email}}">
                            <button class="btn btn-success m-0 mx-3">Gửi email ngay</button>
                        </a>
                        @endif
                    </div>
                    <div class="mb-4">
                        <span>Số điện thoại: {{$support->phonenumber}}</span>
                        @if ($support->status == 'false')
                        <a href="tel:{{$support->phonenumber}}">
                            <button class="btn btn-success m-0 mx-3">Gọi ngay</button>
                        </a>
                        @endif
                    </div>
                    @if ($support->status == 'true')
                    <div class="mb-4">
                        <p>Trạng thái: Đã phản hồi</p>
                    </div>
                    @endif
                @if ($support->status == 'false')
                    <form method="POST" action="{{url('admin/supports/'.$support->id)}}">
                        @csrf
                        <div class="mb-2">
                            <p class="mt-4">Tình trạng</p>
                            <div class="form-check"> 
                                <input class="form-check-input" type="radio" name="status" id="yes" value="true">
                                <label for="yes">Đã phản hồi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="no" value="false" checked>
                                <label for="no">Chưa phản hồi</label>
                            </div>
                        </div>

                            <div class="d-flex flex-row-reverse mt-2">
                                <button type="button" class="btn btn-primary" id="create">Cập nhật</button>
                            </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
</div>
@endsection
@push('js')
<script src="https://cdn.tiny.cloud/1/oqw30ghqa6j0o3dy7d3qoyaa54ug4up3omdgj56z0z7mgifo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    // tinymce.init({
    //     selector: 'textarea#mytextarea',
    //     height: 300,
    //     menubar: false,
    //     encoding : "xml",
    //     plugins: [
    //         'advlist autolink lists link image charmap print preview anchor',
    //         'searchreplace visualblocks code fullscreen',
    //         'insertdatetime media table paste code help wordcount',
    //         'textcolor colorpicker',
    //         'codesample'
    //     ],
    //     toolbar: 'undo redo | formatselect | ' +
    //         'bold italic backcolor | alignleft aligncenter ' +
    //         'alignright alignjustify | bullist numlist outdent indent | ' +
    //         'removeformat | help' + '| codesample |',
    //     content_css: '//www.tiny.cloud/css/codepen.min.css'
    // });
    $(document).ready(function(){
        $('#create').click(function(){
            let $count = 0
            if ($('textarea[name=content]').val() == '' ){
                $('textarea[name=content]').addClass('is-invalid')
            } else {
                $('textarea[name=content]').removeClass('is-invalid')
                $count +=1
            }
            if ($('textarea[name=description]').val() == '' ){
                $('textarea[name=description]').addClass('is-invalid')
            } else {
                $('textarea[name=description]').removeClass('is-invalid')
                $count +=1
            }
            if ($count == 2){
                $('form').submit();
            }
        })
    })
  
</script>
@endpush
