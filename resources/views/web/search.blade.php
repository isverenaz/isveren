@extends('web.layouts.app')

<!-- select2-bootstrap4-theme -->
@section('web.css')
    <style>
        .active-like {
            border-radius: 12px;
            color: #061e40;
            width: 40px;
            height: 40px;
            margin-right: 9px;
            background-color: #f3f6f9;
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
            border-radius: 12px;
            color: #061e40;
            width: 40px;
            height: 40px;
            margin-right: 9px;
            background-color: #f3f6f9;

        }
        .active-dislike {
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 8px;
            background-image: url("{{ asset('web/assets/images/heart-like.png') }}");

            background-size: 18px;
            opacity: 1;
        }

        @media (max-width: 992px) {
            .white {
                display: none;
            }
            .me-4 {
                display: none;
            }
            .wishlist {
                display: none !important;
            }
            .job-top-item {
                display: none !important;
            }
        }
    </style>
@endsection
@section('web.section')
    <section class="breadcrumb-main" style="background-image:url({{ asset('web/assets/images/shape-1.png') }});">
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <div class="banner-content text-center w-85 mx-auto">
                        <h3>@lang('web.copyright')</h3>
                        <p class="mb-4">@lang('web.copyright_text')</p>
                        <div class="book-form box-shadow p-3 pb-0 bg-white rounded main_search">
                            <form action="{{ route('web.home') }}" method="GET">
                                @csrf
                                <div class="row d-flex align-items-center justify-content-between">
                                    <div class="col-lg-10 col-md-6 border-end  mb-2">
                                        <div class="form-group">
                                            <div class="input-box" style="display: flex;">
                                                <input type="text" name="q" class="border-0" placeholder="@lang('web.search')">
                                                <button type="submit" style="background: #fff;">
                                                    <img src="{{ asset('web/assets/img/search.png') }}" style="width: 30px; height: 30px; margin-top: 10px;">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 mb-2">
                                        <div class="form-group text-center">
                                            <a href="#" type="submit" id="myLink" class="w-80">
                                                <img src="{{ asset('web/assets/img/filter.png') }}" style="width: 20px; margin-right: 5px;">
                                                @lang('web.read_more')
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="book-form box-shadow p-3 pb-0 bg-white rounded" style="margin-top: 20px;" id="advanced_search">
                            <div class="s009">
                                <form action="{{ route('job.search') }}" method="POST">
                                    @csrf
                                    <div class="inner-form">
                                        <div class="advance-search">
                                            <div class="row">
                                                <div class="input-field">
                                                    <div class="input-select">
                                                        <select id="categorySelect"  name="categoryId">
                                                            <option  value="">@lang('web.categories')</option>
                                                            @if (!empty($categories))
                                                                @foreach ($categories as $key => $cat)
                                                     
                                                                    @if($cat->parent_id == null)
                                                                        <option value="{{ $cat->id }}"  {{ $cat->id == $categoryId ? 'selected': '' }}> {!! json_decode($cat, true)['name']['az'] !!}</option>
                                                                        @foreach ($cat->subcategory as $sub => $subcategory)
                                                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == $categoryId ? 'selected': '' }}>
                                                                                --- {!! json_decode($subcategory, true)['name']['az'] !!}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-field">
                                                    <div class="input-select">
                                                        <select id="jobTypeSelect" name="jobTypeId">
                                                            <option placeholder=""
                                                                    value="">@lang('web.job_type')</option>
                                                            @if (!empty($jobType))
                                                                @foreach ($jobType as $key => $type)
                                                                    <option value="{{ $type->id }}" {{ $type->id == $jobTypeId ? 'selected' : '' }}>
                                                                        {!! json_decode($type, true)['name']['az'] !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-field">
                                                    <div class="input-select">
                                                        <select id="citySelect" name="citySelect">
                                                            <option placeholder="" value="">Şəhər</option>
                                                            @if (!empty($cities))
                                                                @foreach ($cities as $key => $city)
                                                                    <option value="{{ $city->id }}" {{ $city->id == $citySelect ? 'selected' : '' }}>
                                                                        {!! json_decode($city, true)['name']['az'] !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row second">
                                                <div class="input-field">
                                                    <div class="input-select">
                                                        <select data-trigger="" id="saleSelect" name="saleSelect">
                                                               <option value="0-500" @if($saleSelect == '0-500') selected @endif>0-500</option>
    <option value="500-1000" @if($saleSelect == '500-1000') selected @endif>500-1000</option>
    <option value="1000-2000" @if($saleSelect == '1000-2000') selected @endif>1000-2000</option>
    <option value="2000-5000" @if($saleSelect == '2000-5000') selected @endif>2000-5000</option>
    <option value="5000+" @if($saleSelect == '5000+') selected @endif>5000+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row third">
                                                <div class="input-field">
                                                    <div class="result-count">
                                                        <span id="count">{{ $jobs->total() }} </span>Vakansiya
                                                    </div>
                                                    <div class="group-btn">
                                                        <button class="btn-search">AXTAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dot-overlay" style="margin-top: -50px;"></div>
    </section>

    <section class="find-job bg-lgrey" style="padding-top: 80px;">
        <div class="container">
            <div class="row flex-row-reverse flr">
                <div class="col-lg-4 pe-lg-4 isverenik">
                    <img src="{{ asset('web/assets/images/isveren.jpg') }}" alt="İş verən" class="w-100">
                </div>
                <div class="col-lg-8">
                    <div class="job-box">
                        <div class="row ">
                            <div class="data-wrapper">
                                <x-web.job-data :jobs="$jobs"/>
                            </div>
                            <div class="auto-load text-center" style="display: none;">
                                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                    <path fill="#000" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"/>
                                    </path>
                                </svg>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <div class="pagination-main text-center">
                                    {!! $jobs->onEachSide(0)->links() !!}
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>




    <script>
        $(document).on('change', '#categorySelect, #jobTypeSelect, #citySelect, #saleSelect', function () {
            categoryId = $('#categorySelect').val();
            jobTypeId = $('#jobTypeSelect').val();
            citySelect = $('#citySelect').val();
            saleSelect = $('#saleSelect').val();
            var page = 1;
            var loading = false;

            var url = '/' + "?page=" + page;
            if (jobTypeId != null || categoryId != null || citySelect != null || saleSelect != null) {
                page = 1;
                url = '/' + "?page=" + page + "&categoryId=" + categoryId + "&jobTypeId=" + jobTypeId + "&citySelect=" + citySelect + "&saleSelect=" + saleSelect;
            }
            //page=2
            var scrollTimeout;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    categoryId: categoryId,
                    jobTypeId: jobTypeId,
                    citySelect: citySelect,
                    saleSelect: saleSelect // Include the selected price range
                },
                success: function (data) {
                    if (page === 1) {
                        $("#count").empty().append(data.jobCount);
                    }
                }
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
            }).always(function () {
                loading = false;
            });
        });
    </script>
@endsection




