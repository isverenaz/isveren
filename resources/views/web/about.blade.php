@extends('web.layouts.app')
@section('site.title')
    Haqqımızda
@endsection
@section('web.css')
@endsection
@section('web.section')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ assert('site/images/banner/1.jpg') }});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">@lang('site.about_us')</h2>
                        </div>
                    </div>
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('web.home') }}">@lang('site.home')</a></li>
                            <li>@lang('site.about_us')</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- JOBS CATEGORIES SECTION START -->
        {{--<div class="section-full p-t120 p-b90 site-bg-gray twm-job-categories-area2">
            <!-- TITLE START-->
            <div class="section-head center wt-small-separator-outer">
                <h2 class="wt-title">Bütün Vakansiyalar Kateqoriyalar üzrə</h2>
            </div>
            <!-- TITLE END-->

            <div class="container">

                <div class="twm-job-categories-section-2 m-b30">

                    <div class="job-categories-style1 m-b30">
                        <div class="row">

                            <!-- COLUMNS 1 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-dashboard"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">9,185 Jobs</div>
                                        <a href="job-detail.html">Business Development</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 2 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-project-management"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">3,205 Jobs</div>
                                        <a href="job-detail.html">Project Management</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 3 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-note"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">2,100 Jobs</div>
                                        <a href="job-detail.html">Content Writer</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 4 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-customer-support"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">1,500 Jobs</div>
                                        <a href="job-detail.html">Costomer Services</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 5 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-bars"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">9,185 Jobs</div>
                                        <a href="job-detail.html">Finance</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 6 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-user"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">3,205 Jobs</div>
                                        <a href="job-detail.html">Marketing</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 7 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-computer"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">2,100 Jobs</div>
                                        <a href="job-detail.html">Design &amp; Art</a>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNS 8 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                        <div class="flaticon-coding"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">1,500 Jobs</div>
                                        <a href="job-detail.html">Web Development</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center job-categories-btn">
                        <a href="job-grid.html" class=" site-button">Bütün kateqoryalar</a>
                    </div>

                </div>

            </div>

        </div>--}}
        <!-- JOBS CATEGORIES SECTION END -->

        <!-- HOW IT WORK SECTION START -->
        <div class="section-full p-t120 p-b90 site-bg-white twm-how-it-work-area2">

            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <!-- TITLE START-->
                        <div class="section-head left wt-small-separator-outer">
                            <div class="wt-small-separator site-text-primary">
                                <div>Bizim ilə nə edə bilərsiniz?</div>
                            </div>
                            <h2 class="wt-title">Sadə addımlarla arzularındakı işi tap!.</h2>

                        </div>
                        <ul class="description-list">
                            <li>
                                <i class="feather-check"></i>
                                Yeni iş elanları paylaşılması
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                Yeni işçilərin axtarılması
                            </li>
                            <li>
                                <i class="feather-check"></i>
                               İş həyatında yenililərdən xəbardar olmaq
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                Yeni şirkətlər ilə əlaqələrin qurulması
                            </li>
                        </ul>
                        <!-- TITLE END-->
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="twm-w-process-steps-2-wrap">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-sky-light bg-sky-light-shadow">
                                            <span class="twm-large-number text-clr-sky">01</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('site/images/work-process/icon1.png') }}" alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">Hesabınızı<br>Qeydiyyatdan Keçirin</h4>
                                            <p>Ən uyğun və istədiyiniz işi elanızı paylaşmaq üçün hesab yaratmağınız lazımdır.</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-yellow-light bg-yellow-light-shadow">
                                            <span class="twm-large-number text-clr-yellow">02</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('site/images/work-process/icon4.png') }}" alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">İşinizi <br>Axtarın</h4>
                                            <p>Arzuladığınız karyera üçün ilk addımı atın – işinizi axtarın!</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-pink-light bg-pink-light-shadow">
                                            <span class="twm-large-number text-clr-pink">03</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('site/images/work-process/icon3.png') }}" alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">Arzunuzdakı İşə <br>Müraciət Edin</h4>
                                            <p>İstədiyiniz işə müraciət etmək üçün hesab yaratmağınız lazımdır.</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-green-light bg-clr-light-shadow">
                                            <span class="twm-large-number text-clr-green">04</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('site/images/work-process/icon3.png') }}" alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">CV-nizi <br>Yükləyin</h4>
                                            <p>Yeni cv-i əlavə etmək üçün hesab yaratmağınız lazımdır.</p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="twm-how-it-work-section"></div>
            </div>

        </div>
        <!-- HOW IT WORK SECTION END -->

        <!-- EXPLORE NEW LIFE START -->
        <div class="section-full p-t120 p-b120 twm-explore-area bg-cover " style="background-image: url({{ asset('site/images/background/bg-1.jpg') }});">
            <div class="container">

                <div class="section-content">
                    <div class="row">

                        <div class="col-lg-4 col-md-12">
                            <div class="twm-explore-media-wrap">
                                <div class="twm-media">
                                    <img src="{{ !empty($static_pages)? asset('uploads/static-pages/'.$static_pages['image']): '' }}" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12">
                            <div class="twm-explore-content-outer">
                                <div class="twm-explore-content">

                                    <div class="twm-l-line-1"></div>
                                    <div class="twm-l-line-2"></div>

                                    <div class="twm-r-circle-1"></div>
                                    <div class="twm-r-circle-2"></div>
                                    <div class="twm-title-large">
                                        <h2>{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!} </h2>
                                        <p>{!! !empty($static_pages)? json_decode($static_pages, true)['text']['az']: '' !!}</p>
                                    </div>
                                </div>
                                <div class="twm-bold-circle-right"></div>
                                <div class="twm-bold-circle-left"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- EXPLORE NEW LIFE END -->

        <!-- TOP COMPANIES START -->
        <div class="section-full p-t120  site-bg-white twm-companies-wrap">

            <!-- TITLE START-->
            {{--<div class="section-head center wt-small-separator-outer">
                <div class="wt-small-separator site-text-primary">
                    <div>Əmakdaşlıq etdiyimiz şirkətlər</div>
                </div>
                <h2 class="wt-title">Onlar bizimlə işləməyi seçdilər</h2>
            </div>--}}
            <!-- TITLE END-->

           {{-- <div class="container">
                <div class="section-content">
                    <div class="owl-carousel home-client-carousel2 owl-btn-vertical-center">

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img src="{{ asset('site/images/client-logo/w1.png') }}" alt=""></a></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>--}}


        </div>
        <!-- TOP COMPANIES END -->


    </div>
    <!-- CONTENT END -->
@endsection
@section('web.js')
@endsection
