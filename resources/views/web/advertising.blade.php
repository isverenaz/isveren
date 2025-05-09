<!DOCTYPE html>
<html lang="az">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!}</title>


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

    <meta name="title" content="{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!}" />
    <meta name="description" content="{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!}">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!}" />
    <meta property="og:description" content="{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!}" />

    <x-web.header />

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

<section class="job-single bg-lgrey border-t">
    <div class="container">
        <div class="row">
            <div class="single-content">
                    <div class="job-single-title" style="text-align: center; direction: rtl; !important;">
                        <div class="row align-items-center text-center text-lg-start">
                            <div class="col-lg-7 mb-2">
                                <h3 class="mb-0">{!! !empty($static_pages)? json_decode($static_pages, true)['title']['az']: '' !!}</h3>

                            </div>
                        </div>
                    </div>
                    <div class="job-description mb-2" >
                        {!! !empty($static_pages)? json_decode($static_pages, true)['text']['az']: '' !!}
                    </div>

                </div>
        </div>
    </div>
</section>

</body>

<x-web.footer />
