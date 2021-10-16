@extends('backend.layouts.app')

@section('title')
    Quản lý file
@endsection

@section('content')
<div class="container-fluid py-4">
    <iframe src="{{url('admin/filemanager-plugin')}}" style="width:99%;min-height:900px"></iframe>
</div>
@endsection



