@extends('backend.layouts.app')

@section('title')
    Cập nhật thành phần
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Cập nhật thành phần trang chủ</h5>
                <a href="{{url('admin/homesorts')}}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/homesorts/'.$homesort->id.'/update')}}">
                    @csrf
                    <div class="mb-4">
                        <label for="role">Vị trí</label>
                        <select class="form-control" name="role" id="role">
                            <option value="header" {{$homesort->role == 'header' ? 'selected' : ''}}>Header</option>
                            <option value="section" {{$homesort->role == 'section' ? 'selected' : ''}}>Section</option>
                            <option value="footer" {{$homesort->role == 'footer' ? 'selected' : ''}}>Footer</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="show">Hiển thị</label>
                        <select class="form-control" name="show" id="show">
                            <option value="1" {{$homesort->show == '1' ? 'selected' : ''}}>Có</option>
                            <option value="0" {{$homesort->show == '0' ? 'selected' : ''}}>Không</option>
                        </select>
                    </div>
                    <div>
                        <label for="role">Vị trí</label>
                        <textarea class="form-control" name="content" rows="15" required>{{$homesort->content}}</textarea>
                        <div class="invalid-feedback" id="errorContent">
                            Không để trống trường này
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="show">Mô tả</label>
                        <textarea class="form-control" name="description" required>{{$homesort->description}}</textarea>
                        <div class="invalid-feedback" id="errorDesc">
                            Không để trống trường này
                        </div>
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
