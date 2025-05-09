<!DOCTYPE html>
<html lang="az">
<head>
    @php
        $htmlContent = SEOMeta::getDescription();
        $decodedContent = htmlspecialchars_decode($htmlContent);
        // HTML etiketlerini kaldırmak için strip_tags fonksiyonunu kullanabiliriz.
        $plainTextContent = strip_tags($decodedContent);

        // Metni belirli bir uzunlukta sınırla
        $maxLength = 160; // Örnek olarak 160 karakter
        $plainTextContent = substr($plainTextContent, 0, $maxLength);
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>


    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('web/assets/img/favicon.png') }}">

    <link href="{{ asset('web/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('web/assets/fonts/flaticon.css') }}">

    <link href="{{ asset('web/assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('web/assets/css/plugin.css') }}" rel="stylesheet" type="text/css">

    <link rel="canonical" href="{{ url()->current() }}">

    {{-- <link href="{{ asset('web/assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('web/assets/css/all.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/assets/fonts/line-icons.css') }}" type="text/css">
    <meta http-equiv="content-language" content="az">
    <meta name="keywords" content="isveren.az,iş elanları,vakansiyalar,iw elanlari,Is elanlari 2024">
    <meta name="og:image" content="{{ asset('web/assets/img/favicon.png') }}">

    <meta name="title" content="{{ $title }}" />
    <meta name="description" content="{{ $plainTextContent }}">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $plainTextContent }}" />
    <meta property="og:keyword"
          content="{{ json_decode($blog->jobSeo ?? null, true)['meta_keyword']['az'] ?? null }}">
    <meta property="og:url" content="{{ route('web.blogs-details', $blog->id) }}">

    <x-web.header />

    <style>
        .company-pro img {
            max-width: 60px !important;
        }

        @media (max-width: 768px) {
            .job-sidecontent {
                display: block !important;
            }

            .job-rate {
                justify-content: center !important;
            }

            .company-pro {
                padding-left: 0 !important;
            }

            .job-list {
                text-align: center;
                padding-left: 0 !important;
            }

            .job-title {
                text-align: center;
                padding-left: 0 !important;
            }

        }
    </style>
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



    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7H9FKE7N5B"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7H9FKE7N5B');
    </script>


<body>
<?php
$dateString = $blog->created_at;
$date = new DateTime($dateString);
$months = [
    1 => "Yanvar",
    2 => "Fevral",
    3 => "Mart",
    4 => "Aprel",
    5 => "May",
    6 => "İyun",
    7 => "İyul",
    8 => "Avqust",
    9 => "Sentyabr",
    10 => "Oktyabr",
    11 => "Noyabr",
    12 => "Dekabr"
];
$formattedDate = $date->format('d ') .' '. $months[(int)$date->format('m')].' '.  $date->format('Y');
?>
<section class="job-single bg-lgrey border-t">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="single-content">
                    <div class="job-single-title">
                        <div class="row align-items-center text-center text-lg-start">
                            <div class="col-lg-7 mb-2">
                                <h3 class="mb-0">{{ json_decode($blog, true)['title']['az'] }}</h3>
                                <small>{{ $formattedDate }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="job-description mb-2">
                        {!! json_decode($blog, true)['description']['az'] !!}

                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-12 ps-xl-4">
                <div class="sidebar-sticky sticky1">
                    <div class="sidebar-list bg-grey p-1 rounded">
                        <div class="job-information bg-white p-4 rounded mb-4">
                            <ul class="job-information-list">

                                <li class="d-block border-b mb-2 pb-2">
                                    <i class="fa fa-eye"></i> Baxış sayı
                                    <span class="float-end"> {!! !empty($blog->reads) ? $blog->reads : 0 !!}</span>
                                </li>

                                @if (!empty($blog->created_at))
                                    <li class="d-block border-b mb-2 pb-2">
                                        <i class="fa fa-calendar"></i> Tarix
                                        <span class="float-end">
                                                {{ $formattedDate }}</span>
                                    </li>
                                @endif
                                @if (!empty($blog->jobcategory))
                                    <li class="d-block border-b mb-2 pb-2">
                                        <i class="fa fa-layer-group"></i> @lang('web.category')
                                        <span
                                            class="float-end">{{ json_decode($blog->jobcategory ?? null, true)['name']['az'] ?? null }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</section>

</body>

<x-web.footer />
