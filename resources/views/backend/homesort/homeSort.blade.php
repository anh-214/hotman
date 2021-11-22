@extends('backend.layouts.app')

@section('title')
    Bố cục trang chủ
@endsection
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thuộc</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Vị trí</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Nội dung</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Mô tả</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hiển thị</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thời gian tạo</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Thời gian cập nhật</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Hành động</th>                                   
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
                                                    <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" title="{{$header->description}}"> {{$header->description}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->show == '1' ? 'Có' : 'Không'}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->created_at}}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0"> {{$header->updated_at}}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a type="button" href="{{url('admin/homesorts/'.$header->id.'/up')}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-up"></i></span>
                                                    </a>
                                                    <a type="button" href="{{url('admin/homesorts/'.$header->id.'/down')}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-down"></i></i></span>
                                                    </a>
                                                    
                                                    <a type="button" href="{{url('admin/homesorts/'.$header->id.'/update')}}" class="text-secondary font-weight-bold text-xs">
                                                        <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                                    </a>
                                                    <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteHomeSortModal" data-homesort={{$header->id}}>
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
                                            <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" title="{{$section->description}}"> {{$section->description}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->show == '1' ? 'Có' : 'Không'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$section->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" href="{{url('admin/homesorts/'.$section->id.'/up')}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-up"></i></span>
                                            </a>
                                            <a type="button" href="{{url('admin/homesorts/'.$section->id.'/down')}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-down"></i></i></span>
                                            </a>
                                            
                                            <a type="button" href="{{url('admin/homesorts/'.$section->id.'/update')}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteHomeSortModal" data-homesort={{$section->id}}>
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
                                            <p class="text-center text-xs font-weight-bold mb-0 hint-text" data-bs-toggle="tooltip" title="{{$footer->description}}"> {{$footer->description}}</p>

                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->show == '1' ? 'Có' : 'Không'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->created_at}}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"> {{$footer->updated_at}}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a type="button" href="{{url('admin/homesorts/'.$footer->id.'/up')}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-up"></i></span>
                                            </a>
                                            <a type="button" href="{{url('admin/homesorts/'.$footer->id.'/down')}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-arrow-down"></i></i></span>
                                            </a>
                                            
                                            <a type="button" href="{{url('admin/homesorts/'.$footer->id.'/update')}}" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge badge-sm bg-gradient-success">Cập nhật</span>
                                            </a>
                                            <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteHomeSortModal" data-homesort={{$footer->id}}>
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
 {{-- modal delete --}}
 <div class="modal fade" id="confirmDeleteHomeSortModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa thành phần</h5>
            </div>
            <div class="modal-body">
            <form>
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa thành phần</h6></label>
                <input type="text" class="form-control" name="confirmPasswordDelete">
                <div class="invalid-feedback" id="errorPasswordDelete">
                </div>
                <input type="hidden" class="form-control" name="deleteHomeSortId" >
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="buttonConfirmDeleteHomeSort">Xác nhận</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
{{-- delete promotion modal boostrap --}}
<script>
    $(document).ready(function(){
        $('#confirmDeleteHomeSortModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var promotion = button.data('homesort')
        var modal = $(this)
        modal.find('input[name=deleteHomeSortId]').val(promotion)
        });

        $("#buttonConfirmDeleteHomeSort").click(function(){
            $id = $('input[name=deleteHomeSortId]').val();
            $password = $('input[name=confirmPasswordDelete]')
            if ($password.val() == ''){
                $password.addClass('is-invalid');
                $("#errorPasswordDelete").text('Vui lòng không để trống trường này')
                
            } else {
                $password.removeClass('is-invalid');
                $("#errorPasswordDelete").text('')
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/homesorts/delete",
                    data: {"_token": "{{ csrf_token() }}", 'id': $id, 'password':$password.val()},
                    success: function(data){
                        window.location.reload()                    
                    }
                });
            }
        })
    });
</script>



@endpush
