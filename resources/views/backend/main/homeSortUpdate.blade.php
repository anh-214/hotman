@extends('backend.layouts.app')

@section('title')
    Cập nhật thành phần
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5>Cập nhật thành phần trang chủ</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/homesorts/update/'.$homesort->id)}}">
                    @csrf
                    <div class="mb-4">
                        <label for="role">Vị trí</label>
                        <select class="form-control" name="role" id="role">
                            <option value="header" {{$homesort->role == 'header' ? 'selected' : ''}}>Header</option>
                            <option value="section" {{$homesort->role == 'section' ? 'selected' : ''}}>Section</option>
                            <option value="footer" {{$homesort->role == 'footer' ? 'selected' : ''}}>Footer</option>
                        </select>
                    </div>
                    <textarea id="mytextarea" name="content">{{$homesort->content}}</textarea>
                    <div class="mt-4" id="errorContent" style="color: red;display:none">
                        Không để trống trường này
                    </div>
                    <div class="d-flex flex-row-reverse mt-2">
                        <button type="button" class="btn btn-primary" id="create">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection
@push('js')
<script src="https://cdn.tiny.cloud/1/oqw30ghqa6j0o3dy7d3qoyaa54ug4up3omdgj56z0z7mgifo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea#mytextarea',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            'textcolor colorpicker',
            'codesample'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help' + '| codesample |',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
    $(document).ready(function(){
        $('#create').click(function(){
            for (i=0; i < tinymce.editors.length; i++){
                var content = tinymce.editors[i].getContent(); // get the content
                if (content != '' ){
                    $('#errorContent').hide()
                    $('form').submit();
                }
            }
            $('#errorContent').show()
        })
    })
  
</script>
@endpush
