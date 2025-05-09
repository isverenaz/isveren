@extends('web.users.user-menu')
@section('user.css')
@endsection
@section('user.section')
    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
        <div class="twm-right-section-panel candidate-save-job site-bg-gray">
            <!--Filter Short By-->
            <div class="product-filter-wrap d-flex justify-content-between align-items-center">
                <span class="woocommerce-result-count-left">Müraciət edənlər</span>
            </div>

            <div class="twm-cv-manager-list-wrap">
                <ul>
                    @if(!empty($jobs[0]))
                        @foreach($jobs as $job)
                            @if(!empty($job['job']['id']))
                    <li>
                        <div class="twm-cv-manager-list-style1">
                            <div class="twm-media">
                                <div class="twm-media-pic">
                                    @if(empty($job['user']->image))
                                        <img src="{{ asset("site\img\user.png") }}" alt="">
                                    @else
                                        <img src="{{ asset("uploads/user/userlogo/".$job['user']->image) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="twm-mid-content">
                                <a  class="twm-job-title">
                                    <h4>{{ $job['fullname'] ?? '' }} </h4>
                                </a>
                                <p>{{ $job['email'] ?? '' }} / {{ $job['phone'] ?? '' }}</p>

                                <div class="twm-fot-content">
                                    <div class="twm-left-info">
                                        {{--<p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                        <div class="twm-job-post-duration">1 days ago</div>
                                        <div class="twm-candidates-tag"><span>Full Time</span></div>--}}
                                    </div>
                                    <div class="twm-view-button">
                                        <a href="{{ asset('uploads/job-contact/'.$job['resume']) }}" title="CV yüklə" target="blank" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fa fa-download"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>
                            @else
                                <li class="job-item">
                                    <div class="job-details">
                                        <p class="job-title">Heç bir müraciət tapılmadı!</p>
                                    </div>
                                </li>
                            @endif
                        @endforeach

                    @endif

                </ul>
            </div>

        </div>
    </div>
@endsection
@section('user.js')
@endsection
