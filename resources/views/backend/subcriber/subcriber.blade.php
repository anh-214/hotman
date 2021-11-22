@extends('backend.layouts.app')

@section('title')
    Đăng ký nhận tin
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Quản lí đăng ký nhận tin</h6>
                    <div>
                        <a href="{{url('admin/subcribers/newemail')}}">
                            <button class="btn btn-primary">Gửi thư mới</button>
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-4 mx-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Email đăng ký nhận tin</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thời gian đăng ký</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hành động</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcribers as $subcriber)
                                <tr>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">{{$subcriber->id}}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">{{$subcriber->email}}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">{{$subcriber->created_at}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('admin/subcribers/'.$subcriber->id.'/delete')}}">
                                            <span class="badge badge-sm bg-gradient-primary">Xóa người đăng ký</span>
                                        </a>
                                    </td>
                                </tr>                                                                         
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">{{$subcribers->links('vendor.pagination.bootstrap-4')}}</div>
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
@push('js')
@endpush