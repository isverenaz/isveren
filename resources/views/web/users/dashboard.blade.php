@extends('web.users.user-menu')
@section('user.css')
@endsection
@section('user.section')
    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
        <!--Filter Short By-->
        <div class="twm-right-section-panel site-bg-gray">
            <div class="twm-dash-b-blocks">
                <div class="row">
                    @if(!empty(auth()->guard('web')->user()->userRole->role) && in_array(auth()->guard('web')->user()->userRole->role->slug,['company','admin']))
                        <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                            <div class="panel panel-default">
                                <div class="panel-body wt-panel-body dashboard-card-2 block-gradient">
                                    <div class="wt-card-wrap-2">
                                        <div class="wt-card-icon-2"><i class="flaticon-job"></i></div>
                                        <div class="wt-card-right wt-total-active-listing counter ">{{ $jobActive }}</div>
                                        <div class="wt-card-bottom-2 ">
                                            <h4 class="m-b0">@lang('site.company_jobs')</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                            <div class="panel panel-default">
                                <div class="panel-body wt-panel-body dashboard-card-2 block-gradient-3">
                                    <div class="wt-card-wrap-2">
                                        <div class="wt-card-icon-2"><i class="flaticon-envelope"></i></div>
                                        <div class="wt-card-right wt-total-listing-review counter ">{{ $companyResume }}</div>
                                        <div class="wt-card-bottom-2">
                                            <h4 class="m-b0">@lang('site.company_resume')</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!empty(auth()->guard('web')->user()->userRole->role) && in_array(auth()->guard('web')->user()->userRole->role->slug,['users','admin']))
                        <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                            <div class="panel panel-default">
                                <div class="panel-body wt-panel-body dashboard-card-2 block-gradient-2">
                                    <div class="wt-card-wrap-2">
                                        <div class="wt-card-icon-2"><i class="flaticon-resume"></i></div>
                                        <div class="wt-card-right  wt-total-listing-view counter ">{{$userJobs}}</div>
                                        <div class="wt-card-bottom-2">
                                            <h4 class="m-b0">@lang('site.user_jobs')</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                            <div class="panel panel-default">
                                <div class="panel-body wt-panel-body dashboard-card-2 block-gradient-4">
                                    <div class="wt-card-wrap-2">
                                        <div class="wt-card-icon-2"><i class="flaticon-job-search"></i></div>
                                        <div class="wt-card-right wt-total-listing-bookmarked counter ">{{$userLike}}</div>
                                        <div class="wt-card-bottom-2">
                                            <h4 class="m-b0">@lang('site.user_like')</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="twm-pro-view-chart-wrap">
                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="panel panel-default site-bg-white m-t30">
                            <div class="panel-heading wt-panel-heading p-a20">
                                <h4 class="panel-tittle m-a0"><i class="far fa-bell"></i>Bildirişlər</h4>
                            </div>
                            <div class="panel-body wt-panel-body">

                                <div class="dashboard-list-box list-box-with-icon">
                                    <ul>
                                        @if(!empty($userData['jobContact'][0]))
                                            @foreach($userData['jobContact'] as $jobContact)
                                                <li>
                                                    <i class="fa fa-envelope text-success list-box-icon"></i> <a href="#" class="text-success">{{$jobContact['fullname']}}</a> paylaşdıqınız vakansiya müraciət etdi
                                                    <a href="#" class="close-list-item color-lebel clr-red">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                        {{--<li>
                                            <i class="fa fa-suitcase text-primary list-box-icon"></i>
                                            <a href="#" class="text-primary">PHP Developer </a> vakansiyanız
                                            aktiv edildi
                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </li>--}}
                                        {{--@if(!empty($userData['followers'][0]))
                                            @foreach($userData['followers'] as $follower)
                                                <li>
                                                    <i class="fa fa-bookmark text-warning list-box-icon"></i>
                                                    {{ $follower['user']['name'] }} tərəfindən
                                                    <a href="#" class="text-warning">SEO </a>
                                                    vakansiyanız yadda saxlanıldı
                                                    <a href="#" class="close-list-item color-lebel clr-red">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif--}}
                                    </ul>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('user.js')
@endsection
