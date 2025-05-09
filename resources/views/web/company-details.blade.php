@extends('web.layouts.app')
@section('site.title')
    Şirkət Vakansiyaları
@endsection
@section('web.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .job-list {
            max-width: 800px;
            margin: 20px auto;
            padding: 0;
            list-style: none;
        }

        @media (max-width: 767px) {
            .job-item {
                padding: 10px 15px !important;
            }

            .job-stats {
                transform: translate(0px, 0px) !important;

            }

            .job-title {
                font-size: 16px !important;
                max-width: 200px;
            }

            .premium-job {
                padding-top: 30px; /* Mobilde ekstra üst boşluk */
            }

            .premium-job::before {
                top: 0 !important;; /* Etiketi resmin üst kısmına hizala */
                font-size: 10px !important; /* Küçük yazı boyutu */
                padding: 1px 6px; /* Etiketin boyutunu küçült */
                right: 10px !important;
            }

            .new-job {
                padding-top: 30px; /* Mobilde ekstra üst boşluk */
            }

            .new-job::before {
                top: 0 !important;; /* Etiketi resmin üst kısmına hizala */
                font-size: 10px !important; /* Küçük yazı boyutu */
                padding: 1px 6px; /* Etiketin boyutunu küçült */
                right: 10px !important;
            }

        }

        .job-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            padding: 18px 25px;
            transition: box-shadow 0.3s;
        }

        .job-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .job-logo {
            flex: 0 0 50px;
            margin-right: 15px;
        }

        .job-logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .job-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Taşmayı engelle */
        }

        .job-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 0 0 5px;
            white-space: nowrap; /* Taşmayı engelle */
            overflow: hidden; /* Fazlalıkları gizle */
            text-overflow: ellipsis; /* Üç nokta ekle */

        }

        .job-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            white-space: nowrap;
        }

        .job-company {
            font-size: 14px;
            color: #555;
            margin: 0;
            white-space: nowrap; /* Taşmayı engelle */
            overflow: hidden; /* Fazlalıkları gizle */
            text-overflow: ellipsis; /* Üç nokta ekle */
        }

        .job-stats {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #777;
            white-space: nowrap; /* Tek satırda tut */
            transform: translate(0px, -12px);

        }

        .views {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
            gap: 5px;
        }

        .premium-job {
            border: 2px solid #28a745; /* Yeşil sınır */
            position: relative; /* "Premium" etiketi için */
        }

        .premium-job::before {
            content: "Premium";
            position: absolute;
            top: 0;
            right: 23px;
            background-color: #28a745;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .new-job {
            /*border: 2px solid deepskyblue;*/
            position: relative;
        }

        .new-job::before {
            content: "Yeni";
            position: absolute;
            top: 0;
            right: 23px;
            background-color: #ff5c5c;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 5px;
            text-transform: uppercase;
        }

        @media (max-width: 767px) {
            .wt-bnr-inr {
                height: 380px;
                margin-top: -45px;
            }
        }

    </style>
    <style>
        /*.search-container {*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    background: #ffffff;*/
        /*    border: 2px solid #e0e0e0;*/
        /*    border-radius: 50px;*/
        /*    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);*/
        /*    overflow: hidden;*/
        /*    width: 100%;*/
        /*    padding: 5px 15px;*/
        /*}*/

        .search-container .input-group {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px; /* Aradaki boşluk */
        }

        .search-container .input-group .input-group-text {
            background: none;
            border: none;
            padding: 0;
            color: #6c757d;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-control {
            border: none;
            outline: none;
            box-shadow: none;
            height: 40px;
        }

        .form-control:focus {
            outline: none;
            box-shadow: none;
        }

        .select2-container--default .select2-selection--single {
            border: none;
            height: 40px;
            outline: none;
            display: flex;
            align-items: center;
        }

        .select2-selection__arrow {
            margin-right: 10px;
        }

        .btn-search {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
        }

        .search-container {
            display: flex;
            gap: 15px;
            background-color: white;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: none;
        }

        .form-control, .form-select {
            border: none;
            box-shadow: none;
            outline: none;
            padding: 10px 15px;
            font-size: 1rem;
        }

        .btn-search {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 50px;
            cursor: pointer;
        }

        .btn-search:hover {
            background-color: #0056b3;
        }

        /* Custom dropdown for select */
        #custom-dropdown {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        #mobile-custom-dropdown {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        #custom-dropdown.open {
            display: block;
        }

        #mobile-custom-dropdown.open {
            display: block;
        }


        .custom-dropdown-item {
            padding: 10px;
            cursor: pointer;
            color: #6c757d;
        }

        .mobile-custom-dropdown-item {
            padding: 10px;
            cursor: pointer;
            color: #6c757d;
        }

        .custom-dropdown-item:hover {
            background-color: #007bff;
            color: white;
        }

        .mobile-custom-dropdown-item:hover {
            background-color: #007bff;
            color: white;
        }

        .mobile-search-container {
            display: none;
        }

        @media (max-width: 768px) {
            .side-desktop {
                display: none;
            }


            /* Genel Arama Kutusu Tasarımı */
            .search-container {
                display: flex;
                flex-direction: column;
                gap: 15px;
                width: 100%;
                max-width: 800px;
                background-color: white;
                padding: 15px;
                border-radius: 12px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .input-group {
                display: flex;
                align-items: center;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 8px 15px;
                position: relative;
            }

            .input-group i, .input-group .input-group-text {
                font-size: 1.2rem;
                color: #6c757d;
                margin-right: 10px;
            }

            .form-control, .form-select {
                border: none;
                padding: 0;
                flex: 1;
                font-size: 1rem;
                color: #495057;
                background: none;
                outline: none;
            }

            .form-control::placeholder, .form-select::placeholder {
                color: #adb5bd;
            }

            .form-select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }

            .btn-search {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                font-size: 1rem;
                border-radius: 50px;
                cursor: pointer;
                text-align: center;
            }

            .btn-search:hover {
                background-color: #0056b3;
            }

            /* Mobilde Görünen Tasarım */
            .mobile-search-container {
                display: none; /* Varsayılan olarak gizlenir */
            }


            .desktop-search-container {
                display: none; /* Mobilde masaüstü tasarımı gizle */
            }

            .mobile-search-container {
                display: flex; /* Mobilde mobil tasarımı göster */
                flex-direction: column;
                gap: 15px;
                width: 100%;
                max-width: 400px;
            }

        }
    </style>
@endsection
@section('web.section')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center"
             style="background-image:url({{ asset("site/images/banner/1.jpg") }});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">@lang('site.jobs_content')</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <form id="searchForm">
                        <div class="search-container desktop-search-container">
                            <!-- Search Input -->
                            <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                                <input type="text" class="form-control" name="search" placeholder="@lang('site.search_content')" style="border-radius: 27px!important;">
                            </div>
                            <!-- Search Button -->
                            <button id="searchButton" class="btn btn-search">
                                @lang('site.search')
                            </button>
                        </div>
                    </form>
                    {{--                    mobail--}}
                    <form id="searchFormMobile">
                        <div class="search-container mobile-search-container">
                            <div class="input-group">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control" name="search" placeholder="@lang('site.search_content')">
                                <img src="{{ asset("site/img/filter.png") }}" style="width:19px; height: 19px" data-bs-toggle="modal" data-bs-target="#infoModal"/>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
        </div>
        <!-- INNER PAGE BANNER END -->


        <!-- OUR BLOG START -->
        <div class="section-full p-t120  p-b90 site-bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 rightSidebar">
                        <!-- start deskop filter-->
                        <div class="side-bar side-desktop">
                            <div class="sidebar-elements sidebar-desktop search-bx">
                                <form id="filterForm">
                                    <div class="form-group mb-4">
                                        <h4 class="section-head-small mb-4">@lang('site.main_categories')</h4>
                                        <select class="wt-select-bar-large selectpicker" id="main_category" name="main_category" data-live-search="true" data-bv-field="size">
                                            <option value="">@lang('site.all_main_categories')</option>
                                            @if(!empty($categories[0]))
                                                @foreach($categories as $category)
                                                    <option value="{{$category['id']}}">{!! $category['name']['az'] !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <h4 class="section-head-small mb-4">@lang('site.parent_categories')</h4>
                                        <select class="wt-select-bar-large selectpicker" id="parent_category"
                                                name="parent_category" data-live-search="true" data-bv-field="size">
                                            <option value="">@lang('site.all_parent_categories')</option>
                                        </select>
                                    </div>

                                    <div class="twm-sidebar-ele-filter">
                                        <h4 class="section-head-small mb-4">@lang('site.jobe_type')</h4>
                                        <ul>
                                            <li>
                                                <div class=" form-check">
                                                    <input type="checkbox" name="job_type" class="form-check-input" id="all_job_type" value="">
                                                    <label class="form-check-label" for="all_job_type">@lang('site.all_job_types')</label>
                                                </div>
                                                <span class="twm-job-type-count"></span>
                                            </li>
                                            @if(!empty($jobTypes[0]))
                                                @foreach($jobTypes as $jobType)
                                                    <li>
                                                        <div class=" form-check">
                                                            <input type="checkbox" name="job_type[]" class="form-check-input" id="{{$jobType['id']}}_job_type" value="{{$jobType['id']}}">
                                                            <label class="form-check-label" for="{{$jobType['id']}}_job_type">{!! $jobType['name']['az'] !!}</label>
                                                        </div>
                                                        <span class="twm-job-type-count"></span>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="form-group mb-4">
                                        <h4 class="section-head-small mb-4">@lang('site.cities')</h4>
                                        <select class="wt-select-bar-large selectpicker" id="city" name="city" data-live-search="true" data-bv-field="size">
                                            <option value="">@lang('site.all_cities')</option>
                                            @if(!empty($cities[0]))
                                                @foreach($cities as $city)
                                                    <option value="{{$city['id']}}">{!! $city['name']['az'] !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end deskop filter-->

                        <!-- start Mobile filter modal-->
                        <div class="side-bar-mobile side-mobile">

                            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="infoModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="sidebar-elements search-bx">
                                                <form>
                                                    <div class="form-group mb-4">
                                                        <h4 class="section-head-small mb-4">@lang('site.main_categories')</h4>
                                                        <select class="wt-select-bar-large selectpicker" id="main_category_mobile" id="main_category" data-live-search="true" data-bv-field="size">
                                                            <option value="">@lang('site.main_categories')</option>
                                                            @if(!empty($categories[0]))
                                                                @foreach($categories as $category)
                                                                    <option value="{{$category['id']}}">{!! $category['name']['az'] !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <h4 class="section-head-small mb-4">@lang('site.parent_categories')</h4>
                                                        <select class="wt-select-bar-large selectpicker" id="parent_category_mobile" name="parent_category" data-live-search="true" data-bv-field="size">
                                                            <option value="">@lang('site.all_parent_categories')</option>
                                                        </select>
                                                    </div>

                                                    <div class="twm-sidebar-ele-filter">
                                                        <h4 class="section-head-small mb-4">@lang('site.job_type')</h4>
                                                        <ul>
                                                            <li>
                                                                <div class=" form-check">
                                                                    <input type="checkbox" name="job_type" class="form-check-input" id="all_job_type" value="">
                                                                    <label class="form-check-label" for="all_job_type">@lang('site.all_job_types')</label>
                                                                </div>
                                                                <span class="twm-job-type-count"></span>
                                                            </li>
                                                            @if(!empty($jobTypes[0]))
                                                                @foreach($jobTypes as $jobType)
                                                                    <li>
                                                                        <div class=" form-check">
                                                                            <input type="checkbox" name="job_type[]" class="form-check-input" id="{{$jobType['id']}}_job_type" value="{{$jobType['id']}}">
                                                                            <label class="form-check-label" for="{{$jobType['id']}}_job_type">{!! $jobType['name']['az'] !!}</label>
                                                                        </div>
                                                                        <span class="twm-job-type-count"></span>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <h4 class="section-head-small mb-4">@lang('site.cities')</h4>
                                                        <select class="wt-select-bar-large selectpicker" id="city" name="city" data-live-search="true" data-bv-field="size">
                                                            <option value="">@lang('site.all_cities')</option>
                                                            @if(!empty($cities[0]))
                                                                @foreach($cities as $city)
                                                                    <option value="{{$city['id']}}">{!! $city['name']['az'] !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end Mobile modal-->
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <!--Filter Short By-->
                        <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">
                            <span class="woocommerce-result-count-left">{{--10 @lang('site.job')--}}</span>
                            <form id="statusAndShortByForm" class="woocommerce-ordering twm-filter-select" method="get">
                                <span class="woocommerce-result-count"></span>
                                <select class="wt-select-bar-2 selectpicker" id="short_by" name="short_by" data-live-search="true"
                                        data-bv-field="size">
                                    <option value="">@lang('site.short_by')</option>
                                    <option value="is_start_date">@lang('site.is_start_date')</option>
                                    <option value="is_name">@lang('site.is_name')</option>
                                </select>
                                <select class="wt-select-bar-2 selectpicker" data-live-search="true" data-bv-field="size" id="job_status" name="job_status">
                                    <option value="">@lang('site.all')</option>
                                    <option value="is_new">@lang('site.is_new')</option>
                                </select>
                            </form>

                        </div>

                        <div class="twm-jobs-list-wrap">
                            <ul class="job-list">

                                <div class="data-wrapper">
                                    <x-web.job-data :jobs="$jobs"/>
                                </div>
                                <div class="auto-load text-center" style="display: none;">
                                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                                         viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                    <path fill="#000"
                                          d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                        <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                                          dur="1s" from="0 50 50" to="360 50 50"
                                                          repeatCount="indefinite"/>
                                    </path>
                                </svg>
                                </div>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- OUR BLOG END -->
    </div>
    <!-- CONTENT END -->
@endsection
@section('web.js')
    <script>
        $('#main_category').on('change', function () {
            var categoryId = $(this).val();
            var subCategorySelect = $('#parent_category');

            // Alt kateqoriya seçimlərini tamamilə sil
            subCategorySelect.empty();

            // Varsayılan option əlavə et
            subCategorySelect.append('<option value="">Kateqorya seç</option>');

            // Əgər əsas kateqoriya seçilibsə, AJAX ilə alt kateqoriyaları gətir
            if (categoryId) {
                $.ajax({
                    url: '/sub-category/' + categoryId,
                    type: 'GET',
                    success: function (response) {
                        // Alt kateqoriya selectini boşalt
                        subCategorySelect.empty();
                        // Əlavə olaraq default option əlavə et (məsələn: "Seçin")
                        subCategorySelect.append('<option value="">@lang('site.all_parent_categories')</option>');

                        if (response.length > 0) {
                            $.each(response, function (key, subcategory) {
                                subCategorySelect.append(
                                    '<option value="' + subcategory.id + '">' + subcategory.name.az + '</option>'
                                );
                            });
                        } else {
                            subCategorySelect.append('<option value="">Alt kateqoriya tapılmadı</option>');
                        }
                        subCategorySelect.selectpicker('destroy');
                        subCategorySelect.selectpicker('render');

                        // Selectpicker üçün təzələmə
                        // subCategorySelect.selectpicker('refresh');
                    },

                    error: function () {
                        subCategorySelect.append('<option value="">Xəta baş verdi</option>');
                    }
                });
            }
        });
        $('#main_category_mobile').on('change', function () {
            var categoryId = $(this).val();
            var subCategorySelect = $('#parent_category_mobile');

            // Alt kateqoriya seçimlərini tamamilə sil
            subCategorySelect.empty();

            // Varsayılan option əlavə et
            subCategorySelect.append('<option value="">Kateqorya seç</option>');

            // Əgər əsas kateqoriya seçilibsə, AJAX ilə alt kateqoriyaları gətir
            if (categoryId) {
                $.ajax({
                    url: '/sub-category/' + categoryId,
                    type: 'GET',
                    success: function (response) {
                        // Alt kateqoriya selectini boşalt
                        subCategorySelect.empty();
                        // Əlavə olaraq default option əlavə et (məsələn: "Seçin")
                        subCategorySelect.append('<option value="">@lang('site.all_parent_categories')</option>');

                        if (response.length > 0) {
                            $.each(response, function (key, subcategory) {
                                subCategorySelect.append(
                                    '<option value="' + subcategory.id + '">' + subcategory.name.az + '</option>'
                                );
                            });
                        } else {
                            subCategorySelect.append('<option value="">Alt kateqoriya tapılmadı</option>');
                        }
                        subCategorySelect.selectpicker('destroy');
                        subCategorySelect.selectpicker('render');

                        // Selectpicker üçün təzələmə
                        // subCategorySelect.selectpicker('refresh');
                    },

                    error: function () {
                        subCategorySelect.append('<option value="">Xəta baş verdi</option>');
                    }
                });
            }
        });
    </script>
    @include('components.web.js',['page' => 'company-details'])
@endsection
