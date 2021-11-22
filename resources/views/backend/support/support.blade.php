@extends('backend.layouts.app')

@section('title')
    Hỗ trợ khách hàng
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí hỗ trợ khách hàng</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-4 mx-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Tên khách hàng</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thời gian tạo</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hành động</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                {{-- view category --}}
                                @foreach ($supports as $support)
                                <tr>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">{{$support->id}}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">{{$support->name}}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0" style="color:{{$support->status == 'true' ? 'green' : 'red'}} ">{{$support->status == 'true' ? 'Đã phản hồi' : 'Chưa phản hồi'}}</p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">{{$support->created_at}}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a type="button" class="text-secondary font-weight-bold text-xs" href="{{url('admin/supports/'.$support->id)}}">
                                            <span class="badge badge-sm bg-gradient-primary">Xem chi tiết và trả lời</span>
                                        </a>
                                    </td>
                                </tr>                                                                         
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">{{$supports->links('vendor.pagination.bootstrap-4')}}</div>
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