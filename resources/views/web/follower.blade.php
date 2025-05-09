@extends('web.layouts.app')

@section('web.css')
<style>
    .active-like {
     display: flex;
     align-items: center;
     justify-content: end;
     padding-top: 2px;
     margin-left: 25px;
     border-radius: 12px;
     color: #061e40;
     width: 40px;
     height: 40px;
     margin-right: 9px;
     background-color: #f3f6f9;
     position: absolute;
     right: 25px;
     bottom: 15px;
 }

 .active-like {
     background-position: center;
     background-repeat: no-repeat;
     border-radius: 8px;
     background-image: url("{{ asset('web/assets/images/heart-dislike.png') }}");

     background-size: 18px;
     opacity: 1;
 }

 .active-dislike {
     display: flex;
     align-items: center;
     justify-content: end;
     padding-top: 2px;
     margin-left: 25px;
     border-radius: 12px;
     color: #061e40;
     width: 40px;
     height: 40px;
     margin-right: 9px;
     background-color: #f3f6f9;
     position: absolute;
     right: 25px;
     bottom: 15px;
 }

 .active-dislike {
     background-position: center;
     background-repeat: no-repeat;
     border-radius: 8px;
     background-image: url("{{ asset('web/assets/images/heart-like.png') }}");

     background-size: 18px;
     opacity: 1;
 }


</style>
@endsection
@section('web.section')


    @dd('ss')
    <section class="find-job bg-lgrey">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-8">
{{--                    <div class="list-results d-flex align-items-center justify-content-between mb-3">--}}
{{--                        <div class="list-results-sort">--}}
{{--                            <p class="m-0">Showing 1-5 of 80 results</p>--}}
{{--                        </div>--}}
{{--                        <div class="click-menu d-sm-flex align-items-center justify-content-between">--}}
{{--                            <div class="sortby d-flex align-items-center justify-content-between me-2 mb-1">--}}
{{--                                <select class="niceSelect">--}}
{{--                                    <option value="1">Show To:</option>--}}
{{--                                    <option value="2">10</option>--}}
{{--                                    <option value="3">20</option>--}}
{{--                                    <option value="4">30</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="sortby d-flex align-items-center justify-content-between me-2 mb-1">--}}
{{--                                <select class="niceSelect">--}}
{{--                                    <option value="1">Sort By:</option>--}}
{{--                                    <option value="2">Average rating</option>--}}
{{--                                    <option value="3">Price: low to high</option>--}}
{{--                                    <option value="4">Price: high to low</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="change-list me-2 mb-1"><a href="job-list.html"><i--}}
{{--                                        class="fa fa-bars rounded"></i></a></div>--}}
{{--                            <div class="change-grid f-active mb-1"><a href="job-grid.html"><i--}}
{{--                                        class="fa fa-th rounded"></i></a></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="job-box">
                        <div class="row ">
                            <div class="data-wrapper row">
                                @foreach ($jobs as $data)

                                <div class="job-card box-shadow p-4 rounded bg-white position-relative mb-4 text-center text-md-start">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2 col-md-2">
                                            <div class="company-pro">
                                                <div class="image-box bg-white border-all p-3 px-4 rounded d-inline-block"><i
                                                        class="flaticon-auction fs-2"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                            <small>{{ json_decode($data->city, true)['name']['az'] }}</small>
                                            <h5 class="mb-1"><a href="job-single.html">{{ json_decode($data, true)['title']['az'] }}</a></h5>
                                            <ul class="job-list mb-2">
                                                <li class="job-cats small rounded p-2 px-3 fulltime">
                                                    {{ json_decode($data->jobType, true)['name']['az'] }}</li>
                                                <li class="job-cats small rounded p-2 px-3 private">Private</li>
                                                <li class="job-cats small rounded p-2 px-3 urgent">Urgent</li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="job-sidecontent text-md-end text-center">
                                                <div class="job-rate mb-1">
                                                    <p class="job-price theme2">{{ $data->price }}<span class="text-muted">|hr</span>

                                                        @php
                                                            $userInteraction = auth('web')
                                                                ->user()
                                                                ->followers()
                                                                ->where('job_id', $data->id)
                                                                ->first();

                                                            $defaultInteractionType = $userInteraction->interaction_type ?? null;
                                                        @endphp
                                                        <a href="javascript:void(0)" data-job-id="{{ $data->id }}"
                                                            class="interaction-button {{ $defaultInteractionType === 'like' ? 'active-dislike' : 'active-like' }}"
                                                            data-job-id="{{ $data->id }}" id="test"></a>
                                                    </p>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            </div>

                            <div class="auto-load text-center" style="display: none;">
                                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                                    viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                    <path fill="#000"
                                        d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                            dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 pe-lg-4">
                    <div class="sidebar-sticky">
                        <div class="list-sidebar bg-grey rounded p-4 mb-4">
                            <div class="sidebar-item mb-4">
                                <h4 class>@lang('web.categories')</h4>
                                <ul class="sidebar-category1">
                                    @if (!empty($categories))
                                        @foreach ($categories as $key => $cat)
                                            <li class="checkbox d-flex align-items-center">
                                                <input class="checkbox-pop" type="checkbox"
                                                    id="check{{ $cat['id'] }}">
                                                <label for="check{{ $cat['id'] }}" class="w-100"><span
                                                        class="checkpop"></span>{!! json_decode($cat, true)['name']['az'] !!}
                                                    <span
                                                        class="float-end rounded bg-grey px-2">{{ !empty($cat['jobCategory']) ? $cat['jobCategory']->count() : 0 }}</span></label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="sidebar-item mb-4">
                                <h4 class>@lang('web.salary_range')</h4>
                                <div class="range-slider mt-0">
                                    <div data-min="0" data-max="2000" data-unit="AZN" data-min-name="min_price"
                                        data-max-name="max_price"
                                        class="range-slider-ui ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                        aria-disabled="false">
                                        <span class="min-value">0 AZN</span>
                                        <span class="max-value">20000 AZN</span>
                                        <div class="ui-slider-range ui-widget-header ui-corner-all full"
                                            style="left: 0%; width: 100%;"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                            <div class="sidebar-item">
                                <h4 class>@lang('web.job_type')</h4>
                                <ul class="sidebar-category1">
                                    @if (!empty($jobType))
                                        @foreach ($jobType as $key => $type)
                                            <li class="checkbox d-flex align-items-center d-flex align-items-center">
                                                <input class="checkbox-pop" type="checkbox"
                                                    id="check{{ $type['id'] }}">
                                                <label for="check{{ $type['id'] }}" class="w-100"><span
                                                        class="checkpop"></span>{!! json_decode($type, true)['name']['az'] !!}
                                                    <span
                                                        class="float-end rounded bg-grey px-2">{{ !empty($type['job']) ? $type['job']->count() : 0 }}</span></label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-item">
                            <div
                                class="employee-candid-item bg-theme1 d-flex align-items-center p-4 rounded justify-content-between overflow-hidden position-relative">
                                <div class="employee-candid-content position-relative z-index1">
                                    <h4 class="mb-1 white">Recruiting?</h4>
                                    <p class="white mb-3 small">Excepteur sint occaecat cupidatat non proident, sunt in
                                        culpa qui officia.</p>
                                    <a href="#" class="job-btn1 btn1 d-inline-block">Post A job</a>
                                </div>
                                <div class="employee-candid-image position-relative z-index1 text-end w-75">
                                    <img src="images/ban-image1.png" alt class="w-100">
                                </div>
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>
    $(document).ready(function() {
$('.interaction-button').on('click', function() {

    let button = $(this);
    let jobId = button.data('job-id');
    let interactionType = '';

    if (button.hasClass('active-like')) {
        interactionType = 'like';
    } else if (button.hasClass('active-dislike')) {
        interactionType = 'dislike';
    }

    disablePost = true;

    $.ajax({
        type: 'POST',
        url: '/interact',
        data: {
            job_id: jobId,
            interaction: interactionType,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            console.log(data);
            let interactionType = data.interaction;
            console.log(interactionType);

            button.removeClass('active-like active-dislike');

            if (interactionType === 'like') {
                button.attr('class', 'interaction-button active-dislike');
            } else if (interactionType === 'dislike') {
                button.attr('class', 'interaction-button active-like');
            }

            disablePost = false;
        }
    });
});
});
</script>



