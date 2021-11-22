@extends('backend.layouts.app')

@section('title')
    Quản lí tài khoản User
@endsection
@push('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>    
@endpush
@section('content')
    
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0" style="display: flex; align-items:center;justify-content: space-between;">
                    <h6>Quản lí tài khoản</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-4">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số điện thoại</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian tạo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian cập nhật</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                                <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $users as $user )
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @php
                                                        if (filter_var($user->avatar, FILTER_VALIDATE_URL)) { 
                                                            $image = $user->avatar;
                                                        } else {
                                                            $image = Storage::disk('user-avatar')->url( $user->avatar == null ? 'unknown.png' : $user->avatar);
                                                        }   
                                                        @endphp
                                                        <img src="{{$image}}" class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$user->email}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{$user->phonenumber}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{$user->created_at}}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">{{$user->updated_at}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-email="{{$user->email}}" data-id="{{$user->id}}">
                                                <span class="badge badge-sm bg-gradient-danger" >Xóa</span>
                                                </a>
                                            </td>
                                        </tr>
                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">{{$users->links('vendor.pagination.bootstrap-4')}}</div>
        </div>
    </div>
</div>
{{-- modal delete --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa tài khoản</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="deleteForm">
                <div class="mb-3">
                <label for="confirmPasswordDelete" class="col-form-label"><h6>Nhập mật khẩu của bạn để xác nhận xóa tài khoản</h6><span id="confirmEmail"></span></label>
                <input type="text" class="form-control" name="confirmPasswordDelete">
                <div class="invalid-feedback" id="errorPasswordDelete">
                </div>
                <input type="hidden" class="form-control" name="deleteId" >
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn bg-gradient-danger" id="buttonConfirmDelete">Xác nhận</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style type="text/css">
    img {
    display: block;
    max-width: 100%;
    }
    .preview {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin: 10px;
    border: 1px solid red;
    }
    .modal-lg{
    max-width: 700px !important;
    
    }
    .no-border-bottom{
        margin-bottom: 0px
    }
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

<
{{-- data for delete modal boostrap --}}
<script>
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var email = button.data('email') // Extract info from data-* attributes
    var id = button.data('id')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#confirmEmail').text(email)
    modal.find('input[name=deleteId]').val(id)
    });
</script>

{{-- validation delete modal & ajax --}}
<script>
    $(document).ready(function(){
        $("#buttonConfirmDelete").click(function(){
            if ($("input[name=confirmPasswordDelete]").val() == ''){
                $("input[name=confirmPasswordDelete]").addClass('is-invalid');
                $("#errorPasswordDelete").text('Vui lòng nhập mật khẩu của bạn')
            } else {
                $("input[name=confirmPasswordDelete]").removeClass('is-invalid');
                $("#errorPasswordDelete").text('')
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/manager/users/"+$("input[name=deleteId]").val()+"/delete",
                    data: {"_token": "{{ csrf_token() }}", 'confirmPassword': $("input[name=confirmPasswordDelete]").val()},
                    success: function(data){
                        window.location.reload()
                    }
                });
            }
        })
    });

</script>
@endpush