@extends('backend.layouts.app')

@section('title')
    Gửi tin mới
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5>Gửi tin mới cho khách hàng đăng ký</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/subcribers/action')}}">
                    @csrf
                    <input type="hidden" name="action">
                    <div class="mb-4">
                        <label for="role">Tiêu đề thư</label>
                        <input type="text" class="form-control" name="title" required>
                        <div class="invalid-feedback" id="errorTitle">
                            Không để trống trường này
                        </div>
                    </div>
                    <div>
                        <label for="role">Nội dung</label>
                        <textarea class="form-control" name="content" rows="14" required id="myarea"></textarea>
                        <div class="invalid-feedback" id="errorContent">
                            Không để trống trường này
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse mt-2">
                        <button type="button" class="btn btn-primary" id="preview">Xem trước thư gưi</button>
                        <button type="button" class="btn btn-success mx-2" id="confirm">Xác nhận gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection
@push('js')
<script src="https://cdn.tiny.cloud/1/oqw30ghqa6j0o3dy7d3qoyaa54ug4up3omdgj56z0z7mgifo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker link image imagetool',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table lignleft aligncenter alignright alignjustify image',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        height : "480",
        file_picker_callback: function (callback, value, meta) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        let type = 'image' === meta.filetype ? 'Images' : 'Files',
            url  = '/admin/filemanager-plugin?editor=tinymce5&type=' + type;

        tinymce.activeEditor.windowManager.openUrl({
            url : url,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content);
            }
        });
    }
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#preview').click(function(){
            $('input[name=action]').val('preview')
            let $count = 0
            if ($('input[name=title]').val() == '' ){
                $('input[name=title]').addClass('is-invalid')
            } else {
                $('input[name=title]').removeClass('is-invalid')
                $count +=1
            }
            var content = tinyMCE.activeEditor.getContent();
            if (content === "" || content === null) {
                $('textarea[name=content]').addClass('is-invalid')
            } else {
                $('textarea[name=content]').removeClass('is-invalid')
                $count +=1
            }
            if ($count == 2){
                $('form').submit();
            }
        })
        $('#confirm').click(function(){
            $('input[name=action]').val('confirm')
            let $count = 0
            if ($('input[name=title]').val() == '' ){
                $('input[name=title]').addClass('is-invalid')
            } else {
                $('input[name=title]').removeClass('is-invalid')
                $count +=1
            }
            var content = tinyMCE.activeEditor.getContent();
            if (content === "" || content === null) {
                $('textarea[name=content]').addClass('is-invalid')
            } else {
                $('textarea[name=content]').removeClass('is-invalid')
                $count +=1
            }
            if ($count == 2){
                $('form').submit();
            }
        })
    })
  
</script>
@endpush
