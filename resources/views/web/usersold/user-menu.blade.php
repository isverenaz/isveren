<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>İş Verən | @lang('web.dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('web/assets/img/favicon.png') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset("user/assets/css/bootstrap.min.css") }}" id="bootstrap-style" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('user/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset("user/assets/css/icons.min.css") }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    @yield('user.css')
</head>

<body data-sidebar="dark" data-layout-mode="light">
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ route('web.home') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('web/assets/img/isveren-logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('web/assets/img/isveren-logo.png') }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{ route('web.home') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('web/assets/img/favicon.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('web/assets/img/isveren-logo.png') }}" alt="" style="width: 151px!important;

    height: 37px!important;">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>

            <div class="d-flex">


                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="@if(isset(auth()->guard('web')->user()->image)) {{asset('uploads/user/image/'.auth()->guard('web')->user()->image) }} @else {{ asset('user/user.png') }} @endif"
                             alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{auth()->guard('web')->user()->name}} {{auth()->guard('web')->user()->surname}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="{{ route('web.user.settings',auth()->guard('web')->user()->id) }}">
                            <i class="bx bx-user font-size-16 align-middle me-1"></i>
                            <span key="t-profile">@lang('web.profile')</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ route('web.user.logout') }}">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                            <span key="t-logout">@lang('web.logout')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu"></li>
                    @if(!empty(auth()->guard('web')->user()->userRole->role) && auth()->guard('web')->user()->userRole->role->slug == 'users')

                        <li>
                            <a href="{{ route('web.user.cv') }}" class="waves-effect">
                                <i class="bx bxs-file-pdf"></i>
                                <span key="t-dashboards">CV yarat</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('web.user.follower') }}" class="waves-effect">
                                <i class="bx bx-heart"></i>
                                <span key="t-dashboards">@lang('web.follower_list')</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('web.user.company.list') }}" class="waves-effect">
                                <i class="bx bx-home"></i>
                                <span key="t-dashboards">@lang('web.company')</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('web.user.jobs.list') }}" class="waves-effect">
                                <i class="bx bx-list-check"></i>
                                <span key="t-dashboards">@lang('web.jobs_list')</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('web.user.settings',auth()->guard('web')->user()->id) }}" class="waves-effect">
                            <i class="bx bx-user"></i>
                            <span key="t-dashboards">@lang('web.settings')</span>
                        </a>
                    </li>


                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
    <div class="main-content">
        @yield('user.section')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<script>
    $('.select2').select2({ placeholder : '' });

    $('.select2-remote').select2({ data: [{id:'A', text:'A'}]});

    $('button[data-select2-open]').click(function(){
      $('#' + $(this).data('select2-open')).select2('open');
    });
  </script>
<!-- END layout-wrapper -->
<script src="{{ asset('user/assets/libs/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('user/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


<script src="{{ asset('user/assets/libs/metismenu/metisMenu.min.js') }}"></script>

<script src="{{ asset('user/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('user/assets/libs/node-waves/waves.min.js') }}"></script>
<!-- apexcharts -->
<script src="{{ asset('user/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- dashboard init -->
<script src="{{ asset('user/assets/js/pages/dashboard.init.js') }}"></script>
<!-- App js -->
<script src="{{ asset('user/assets/js/app.js') }}"></script>


@yield('user.js')


</body>
</html>
