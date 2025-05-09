<header class="site-header header-style-3 mobile-sider-drawer-menu">

    <div class="sticky-header main-bar-wraper  navbar-expand-lg">
        <div class="main-bar">

            <div class="container-fluid clearfix">

                <div class="logo-header">
                    <div class="logo-header-inner logo-header-one">
                        <a href="{{ route('web.home') }}">
                            <img src="{{ asset('site/images/logo/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>

                <!-- NAV Toggle Button -->
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button"
                        class="navbar-toggler collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar icon-bar-first"></span>
                    <span class="icon-bar icon-bar-two"></span>
                    <span class="icon-bar icon-bar-three"></span>
                </button>

                <!-- MAIN Vav -->
                <div class="nav-animation header-nav navbar-collapse collapse d-flex justify-content-center">

                    <ul class=" nav navbar-nav">
                        <li>
                            <a href="{{ route('web.about') }}">@lang('site.about_us')</a>
                        </li>

                        {{--<li>
                            <a href="{{ route('web.vacancy') }}">@lang('site.vacancy')</a>
                        </li>--}}

                        <li>
                            <a href="{{ route('web.professions') }}">@lang('site.professions')</a>
                        </li>

                        <li>
                            <a href="{{ route('web.companies') }}">@lang('site.companies')</a>
                        </li>

                        {{--<li>
                            <a href="{{ route('web.blogs') }}">@lang('site.blogs')</a>
                        </li>--}}

                        <li>
                            <a href="{{ route('web.cv') }}">@lang('site.job_seekers')</a>
                        </li>

                        <li>
                            <a href="{{ route('web.contact') }}">@lang('site.contact_us')</a>
                        </li>

                        {{--<li class="has-mega-menu"><a href="javascript:;">Home</a>
                            <ul class="mega-menu">
                                <li>
                                    <ul>
                                        <li><a href="index.html">Home-1</a></li>
                                        <li><a href="index-2.html">Home-2</a></li>
                                        <li><a href="index-3.html">Home-3</a></li>
                                        <li><a href="index-4.html">Home-4</a></li>
                                        <li><a href="index-5.html">Home-5</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <ul>
                                        <li><a href="index-6.html">Home-6</a></li>
                                        <li><a href="index-7.html">Home-7</a></li>
                                        <li><a href="index-8.html">Home-8</a></li>
                                        <li><a href="index-9.html">Home-9</a></li>
                                        <li><a href="index-10.html">Home-10</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <ul>
                                        <li><a href="index-11.html">Home-11</a></li>
                                        <li><a href="index-12.html">Home-12</a></li>
                                        <li><a href="index-13.html">Home-13</a></li>
                                        <li><a href="index-14.html">Home-14</a></li>
                                        <li><a href="index-15.html">Home-15</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <ul>
                                        <li><a href="index-16.html">Home-16</a></li>
                                        <li><a href="index-17.html">Home-17</a></li>
                                        <li><a href="index-18.html">Home-18</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>--}}

                    </ul>

                </div>

                <!-- Header Right Section-->
                <div class="extra-nav header-2-nav">
                    <div class="extra-cell">
                        <div class="header-nav-btn-section">
                            <div class="twm-nav-btn-left">
                                @if(!empty(auth()->guard('web')->user()))
                                    <a class="twm-nav-sign-up" href="{{ route('web.user.dashboard') }}">
                                        <i class="feather-user-check"></i> Hesabım
                                    </a>
                                @else
                                    <a class="twm-nav-sign-up" href="{{ route('web.login') }}">
                                        <i class="feather-user-check"></i> @lang('web.login')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>
<!-- HEADER END -->
