@extends('backend.layouts.app')

@section('title')
    Bố cục trang chủ
@endsection
@push('css')
    <style>
        .hint-text{
            width: 10em; /* the element needs a fixed width (in px, em, %, etc) */
            overflow: hidden; /* make sure it hides the content that overflows */
            white-space: nowrap; /* don't break the line */
            text-overflow: ellipsis; /* give the beautiful '...' effect */
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí bố cục</h6>
                    <div>
                        <a type="button" href="{{url('admin/homesorts/create')}}" class="text-secondary font-weight-bold text-xl" >
                            <span class="badge badge-sm bg-gradient-success">Thêm</span>
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-4 mx-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Role</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Position</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Content</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Create_at</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Update_at</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Action</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($homesorts->headers as $header )
                                            <tr>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->id}}</p>
                                                </td>
                                                <td class="w-5">
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->role}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->position}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" title="{{$header->content}}"> {{$header->content}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->created_at}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->updated_at}}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a type="button" href="{{url('admin/homesorts/up/'.$header->id)}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-up"></i></span>
                                                    </a>
                                                    <a type="button" href="{{url('admin/homesorts/down/'.$header->id)}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-down"></i></i></span>
                                                    </a>
                                                    
                                                    <a type="button" href="{{url('admin/homesorts/update/'.$header->id)}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                                    </a>
                                                    <a type="button" href="{{url('admin/homesorts/delete/'.$header->id)}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                                    </a>
                                                </td>
                                            </tr>
                                @endforeach       
                                @foreach ($homesorts->sections as $section )
                                    <tr>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->id}}</p>
                                        </td>
                                        <td class="w-5">
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->role}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->position}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" title="{{$section->content}}"> {{$section->content}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" href="{{url('admin/homesorts/up/'.$section->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-up"></i></span>
                                            </a>
                                            <a type="button" href="{{url('admin/homesorts/down/'.$section->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-down"></i></i></span>
                                            </a>
                                            
                                            <a type="button" href="{{url('admin/homesorts/update/'.$section->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" href="{{url('admin/homesorts/delete/'.$section->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach   
                                @foreach ($homesorts->footers as $footer )
                                    <tr>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->id}}</p>
                                        </td>
                                        <td class="w-5">
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->role}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->position}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" title="{{$footer->content}}"> {{$footer->content}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" href="{{url('admin/homesorts/up/'.$footer->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-up"></i></span>
                                            </a>
                                            <a type="button" href="{{url('admin/homesorts/down/'.$footer->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-down"></i></i></span>
                                            </a>
                                            
                                            <a type="button" href="{{url('admin/homesorts/update/'.$footer->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" href="{{url('admin/homesorts/delete/'.$footer->id)}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-danger">Xóa</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @isset($categories)
                <div class="d-flex justify-content-center">{{$categories->links('vendor.pagination.bootstrap-4')}}</div>
            @endisset
        </div>
    </div>
</div>
@endsection
@push('js')

  

@endpush
