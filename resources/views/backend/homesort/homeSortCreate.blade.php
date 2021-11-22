@extends('backend.layouts.app')

@section('title')
    Thêm thành phần
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5>Thêm thành phần trang chủ</h5>
            </div>
            <div class="card-body">
                <form method="POST" >
                    @csrf
                    <div class="mb-4">
                        <label for="role">Vị trí</label>
                        <select class="form-control" name="role" id="role">
                            <option value="header">Header</option>
                            <option value="section">Section</option>
                            <option value="footer">Footer</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="show">Hiển thị</label>
                        <select class="form-control" name="show" id="show">
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div>
                        <label for="role">Nội dung</label>
                        <textarea class="form-control" name="content" rows="14" required></textarea>
                        <div class="invalid-feedback" id="errorContent">
                            Không để trống trường này
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="show">Mô tả</label>
                        <textarea class="form-control" name="description" required></textarea>
                        <div class="invalid-feedback" id="errorDesc">
                            Không để trống trường này
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse mt-2">
                        <button type="button" class="btn btn-primary" id="create">Thêm</button>
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
