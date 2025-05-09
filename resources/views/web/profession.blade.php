@extends('web.layouts.app')
@section('web.css')
    <style>
        .search-container {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 10px 40px 10px 20px;
            border: 1px solid #e4e4e4;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .search-button {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-40%);
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            padding-right: 18px;
        }

        .search-button i {
            font-size: 18px;
        }

        .letters-list {
            width: 100%;
            text-align: center;
            background-color: #f4f4f4;
            border-radius: 4px;
            padding: 20px;
        }

        .letters-list a {
            display: inline-block;
            font-size: 18px;
            color: #333;
            height: 40px;
            width: 40px;
            line-height: 40px;
            background-color: transparent;
            border-radius: 4px;
            transition: .3s;
            margin: 0 -2px;
        }


        .categories-container {
            display: flex;
            flex-wrap: wrap;
        }

        .category-box {
            flex: 0 0 25%;
            align-content: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            margin: 0;
            text-align: center;
            padding: 25px;
            border-radius: 4px;
            transition: .35s;
        }

        @media (max-width: 480px) {
            .category-box {
                flex: 0 0 100%;
                margin-right: 0;
            }
        }

        @media (max-width: 768px) {
            .category-box {
                flex: 0 0 50%;
            }
        }


        .autocomplete-suggestions {
            border: 1px solid #e4e4e4;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            position: absolute;
            z-index: 9999;
            width: 98.2%;
        }

        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
        }

        .highlight {
            font-weight: bold;
        }

        @media (max-width: 576px) {
            /* Mobile screens */
            .category-box {
                padding: 10px;
            }

            .company-title {
                margin-top: 35px !important;
            }
        }

        @media (min-width: 768px) {
            .category-box {
                display: inline-block;
                width: 100%;
                margin-bottom: 15px;
            }


        }

    </style>
@endsection
@section('web.section')
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ asset('site/images/banner/1.jpg') }});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">@lang('site.professions')</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('web.home') }}">@lang('site.home')</a></li>
                            <li>@lang('site.professions')</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
<section class="mt-4" style="background-image:url({{ asset('web/assets/images/shape-1.png') }});">
    <div class="breadcrumb-outer">
        <div class="container">
            <div class="col-xl-12">
                <form method="GET" action="{{ url('/professions') }}">
                    <div class="search-container">
                        <input type="text" class="form-control search-input" style="border-radius: 0" name="search"
                               placeholder="ixtisasın adını yazmağa başla" id="company_autocomplete"
                               autocomplete="off" value="{{ request()->input('search') }}">
                        <button class="search-button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="hidden" name="index" value="{{ $index }}">

                    </div>
                </form>
                <div id="autocomplete-results" class="autocomplete-suggestions"></div>

            </div>

            <div class="letters-list mt-4">

                @php
                    $azAlphabet = ['A', 'B', 'C', 'Ç', 'D', 'E', 'Ə', 'F', 'G', 'H', 'X', 'İ', 'J', 'K', 'Q', 'L', 'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'];
                @endphp
                @foreach ($azAlphabet as $char)
                    <a href="{{ url('/professions?index=' . $char) }}"
                       class="{{ $index == $char ? 'current' : '' }}">{{ $char }}</a>
                @endforeach

            </div>

            <div class="section company-title mt-65" style="margin-top: 55px">
                <div class="container" style="margin-bottom: 30px">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="categories-container" id="categories_view">

                                @foreach ($jobs as $data)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <a href="{{ route('web.job-details', $data->id) }}" class="category-box">
                                            <div class="category-box-content">
                                                <h3>{{ $data->title['az'] }}</h3>
                                            </div>
                                        </a>
                                    </div>


                                    @php
                                        if ($data) {
                                            $title = isset(json_decode($data, true)['title']['az']) ? json_decode($data, true)['title']['az'] : null;
                                            $description = isset(json_decode($data, true)['description']['az']) ? json_decode($data, true)['description']['az'] : null;
                                            $companyName = isset(json_decode($data->company, true)['name']['az']) ? json_decode($data->company, true)['name']['az'] : null;
                                            $cityName = isset(json_decode($data->city, true)['name']['az']) ? json_decode($data->city, true)['name']['az'] : null;

                                            $shortenedDescription = mb_substr($description, 0, 200);
                                            $cleanedDescription = strip_tags($shortenedDescription);

                                            $datePosted = isset($data->created_at) ? date('Y-m-d',strtotime($data->created_at)) : null;
                                            $validThrough = isset($data->updated_at) ? date('Y-m-d',strtotime($data->updated_at)) : null;
                                        } else {
                                            $title = null;
                                            $cleanedDescription = null;
                                            $companyName = null;
                                            $cityName = null;
                                            $datePosted = null;
                                            $validThrough = null;
                                        }
                                    @endphp

                                    <script type="application/ld+json">
                                        {
                                            "@context": "https://schema.org/",
                                            "@type": "JobPosting",
                                            "title": "{{ $title }}",
            "description": "{!! $cleanedDescription !!}",
            "datePosted": "{{ $datePosted }}",
            "validThrough": "{{ $validThrough }}",
            "hiringOrganization": {
                "@type": "Organization",
                "name": "{{ $companyName }}"
            },
            "jobLocation": {
                "@type": "Place",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "{{ $cityName }}",
                }
            }
        }
                                    </script>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12 mb-4">
                    <div class="pagination-main text-center">
                        {{ $jobs->onEachSide(0)->appends(['index' => $index, 'search' => request()->input('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    </div>
@endsection
@section('web.js')
    {{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

        $(document).ready(function() {
            $('#company_autocomplete').on('keyup', function() {
                var query = $(this).val();
                if (query.length > 2) {
                    $.ajax({
                        url: "https://isveren.az/autocomplete",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#autocomplete-results').empty();
                            if (data.length > 0) {
                                data.forEach(function(job) {
                                    var title = job.title.az;
                                    var highlightedTitle = title.replace(new RegExp('('+query+')', 'gi'), '<span class="highlight">$1</span>');
                                    $('#autocomplete-results').append('<div class="autocomplete-suggestion" data-title="' + job.title.az + '">' + highlightedTitle + '</div>');
                                });
                            } else {
                                $('#autocomplete-results').append('<div class="autocomplete-suggestion">No results found</div>');
                            }
                        },
                        error: function(xhr) {
                            console.log('AJAX request failed:', xhr);
                        }
                    });
                } else {
                    $('#autocomplete-results').empty();
                }
            });

            $(document).on('click', '.autocomplete-suggestion', function() {
                var selectedTitle = $(this).data('title');
                window.location.href = "{{ url('/professions') }}?search=" + encodeURIComponent(selectedTitle) + "&index={{ $index }}";
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#company_autocomplete').length && !$(e.target).closest('#autocomplete-results').length) {
                    $('#autocomplete-results').empty();
                }
            });
        });




        // Helper function to get query parameters from the URL
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
            var results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }


        // Click category show and none
        $(document).ready(function() {
            $("#myLink").on("click", function(e) {
                e.preventDefault();

                var currentId = $(this).attr("id");
                if (currentId === "new") {
                    $(this).attr("id", "showLink");
                    $("#advanced_search").addClass("hidden");
                } else {
                    $("#advanced_search").removeClass("hidden");
                    $(this).attr("id", "new");
                }
            });
        });
    </script>--}}
@endsection
