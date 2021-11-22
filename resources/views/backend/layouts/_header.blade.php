

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">
                        HOTMAN
                    </a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{$select}}
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">
                {{$select}}
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                @isset($search)
                    <form method="GET" id="formSearch">
                        <div class="input-group">
                            <span id="btnSearch" class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm" value="{{$search}}">
                        </div>
                    </form>
                @endisset
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer" style="font-size: 15pt"></i>
                        @php
                            $not_reads = \App\Models\Order::where('is_read','false')->latest()->get();
                        @endphp
                        <span class="notification-count" @if($not_reads->count() == 0) style="display: none" @endif>{{$not_reads->count()}}</span>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton" id="dropdownNotification">
                        @foreach ($not_reads as $not_read )
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="{{url('admin/orders/'.$not_read->id)}}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                    <img src="
                                    @if (filter_var($not_read->user->avatar,FILTER_VALIDATE_URL))
                                        {{$not_read->user->avatar}}
                                    @else
                                        {{Storage::disk('user-avatar')->url($not_read->user->avatar == null ? 'unknown.png' : $not_read->user->avatar)}}
                                    @endif
                                    " class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">Đơn hàng mới từ khách hàng: {{$not_read->user->name}}</h6>
                                    <p class="text-xs text-secondary mb-0">
                                        <i class="fa fa-clock me-1"></i>
                                        @php 
                                            Carbon\Carbon::setLocale('vi');
                                            echo $not_read->created_at->diffForHumans(Carbon\Carbon::now());
                                        @endphp
                                    </p>
                                    </div>
                                </div>
                                </a>
                            </li>
                        @endforeach
                        @if($not_reads->count() == 0)
                            <li class="mb-2">
                                <span class="dropdown-item border-radius-md">
                                    Bạn hiện không có thông báo nào 
                                </span>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>