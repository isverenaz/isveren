@extends('web.layouts.app')
@section('site.title')
    {{ $title }}
@endsection
@section('web.css')
    @php
        $htmlContent = SEOMeta::getDescription();
        $decodedContent = htmlspecialchars_decode($htmlContent);
        // HTML etiketlerini kaldırmak için strip_tags fonksiyonunu kullanabiliriz.
        $plainTextContent = strip_tags($decodedContent);

        // Metni belirli bir uzunlukta sınırla
        $maxLength = 160; // Örnek olarak 160 karakter
        $plainTextContent = substr($plainTextContent, 0, $maxLength);
    @endphp
    <meta name="title" content="{{ $title }}"/>
    <meta name="description" content="{{ $plainTextContent }}">
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:description" content="{{ $plainTextContent }}"/>
    <meta property="og:keyword" content="{{ json_decode($job->jobSeo ?? null, true)['meta_keyword']['az'] ?? null }}">
    <meta property="og:url" content="{{ route('web.job-details', $job->id) }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7H9FKE7N5B"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-7H9FKE7N5B');
    </script>
@endsection
@section('web.section')
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center"
             style="background-image:url({{ asset('site/images/banner/1.jpg') }});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">{!! $job['title']['az'] !!}</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('web.home') }}">@lang('site.home')</a></li>
                            <li>{!! $job['title']['az'] !!}</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->


        <!-- OUR BLOG START -->
        <div class="section-full  p-t120 p-b90 bg-white">
            <div class="container">

                <!-- BLOG SECTION START -->
                <div class="section-content">
                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-8 col-md-12">
                            <!-- Candidate detail START -->
                            <div class="cabdidate-de-info">
                                <div class="twm-job-self-wrap">
                                    <div class="twm-job-self-info">
                                        <div class="twm-job-self-top">
                                            <div class="twm-mid-content">

                                                <div class="twm-media">
                                                    @if(json_decode($job->company, true)['logo'] && json_decode($job->company, true)['logo'] !='null.png')
                                                        <img style="width: 100%; height: 100%; object-fit: contain;!important;" alt=""
                                                             src="{{ asset("uploads/companies/logo/".json_decode($job->company, true)['logo']) }}">
                                                    @else
                                                            <?php
                                                            $company_name = json_decode($job->company, true)['name']['az'] ?? "$";
                                                            $first = substr(trim($company_name), 0, 1);
                                                            if ($first == '"') {
                                                                $first = substr(trim($company_name), 1, 2);
                                                            }
                                                            ?>
                                                        <div class="vacancies__icon" data-color="#4B21F3">
                                                            <div class="vc_icon_back"
                                                                 style="background-color:#4B21F3;"></div>
                                                            <span style="color:#4B21F3 !important;"> {{$first}} </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <h4 class="twm-job-title">{!! $job['title']['az'] !!}
                                                    <span class="twm-job-post-duration"> -
                                                        <i class="fas fa-user-tie"></i> {!! $job['company']['name']['az'] !!} /
                                                        <i class="feather-map-pin"></i> {!! $job['company']['address']['az'] !!}
                                                    </span>
                                                </h4>
                                                <div class="twm-social-tags">
                                                    @if(!empty($job['email']) && $job['email'] != '--')
                                                        <a href="mailto:{{$job['email']  ?? ''}}"
                                                           class="fb-clr">E-poçt</a>
                                                    @endif
                                                    @if(!empty($job['phone']) && $job['phone'] != '--')
                                                        <a href="tel:{{$job['phone']  ?? ''}}" class="whats-clr">Əlaqə
                                                            nömrəsi</a>
                                                    @endif
                                                </div>
                                                @if(!empty(auth()->guard('web')->user()))
                                                    <div class="twm-job-self-bottom">
                                                        <a class="site-button" data-bs-toggle="modal"
                                                           href="#apply_job_popup" role="button">
                                                            İndi müraciət et
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="twm-job-self-bottom">
                                                        <a class="site-button" href="{{ route('web.login') }}"
                                                           target="_blank">
                                                            Kabnetinizi aktiv edin
                                                        </a>
                                                    </div>
                                                    <small>Zəhmət olmasa müraciət üçün kabnetinizi
                                                        aktivləşdirin.</small>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <p>{!! $job['description']['az'] !!}</p>
                                <h4 class="twm-s-title">Paylaş</h4>
                                <div class="twm-social-tags">
                                    <a href="#" class="fb-clr" id="share-facebook" target="_blank">Facebook</a>
                                    <a href="#" class="link-clr" id="share-linkedin" target="_blank">Linkedin</a>
                                    <a href="#" class="whats-clr" id="share-whatsapp" target="_blank">Whatsapp</a>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 rightSidebar">

                            <div class="side-bar mb-4">
                                <div class="twm-s-info2-wrap mb-5">
                                    <div class="twm-s-info2">
                                        <ul class="twm-job-hilites">
                                            <?php
                                            $datePosted = isset($job->start_date) ? date('Y-m-d', strtotime($job->start_date)) : null;
                                            if (empty($datePosted)){
                                                $datePosted = isset($job->created_at)? date('Y-m-d', strtotime($job->created_at)) : null;
                                            }

                                            $endDatePosted = isset($job->end_date) ? date('Y-m-d', strtotime($job->end_date)) : null;
                                            if (empty($endDatePosted)){
                                                $endDatePosted = isset($job->updated_at) ? date('Y-m-d', strtotime($job->updated_at)) : null;
                                            }
                                            $date = new DateTime($datePosted);
                                            $endDate = new DateTime($endDatePosted);
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
                                            $created_at = $date->format('d ') . $months[(int)$date->format('m')];
                                            $end_at = $endDate->format('d ') . $months[(int)$endDate->format('m')];
                                            ?>
                                            <li>
                                                <i class="fas fa-calendar-alt"></i>
                                                <span class="twm-title">Paylaşım tarixi: {{$created_at}}</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-calendar-alt"></i>
                                                <span class="twm-title">Son tarix: {{$end_at}}</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-user-tie"></i>
                                                <div class="twm-title">Əsas
                                                    kateqorya: {{ $job['jobcategory']['category']['name']['az'] ?? 'Qeyd edilməyib' }}</div>
                                            </li>
                                            <li>
                                                <i class="fas fa-user-tie"></i>
                                                <div class="twm-title">
                                                    Kateqorya: {{ $job['jobcategory']['subcategory']['name']['az'] ?? 'Qeyd edilməyib' }}</div>
                                            </li>
                                            <li>
                                                <i class="fas fa-clock"></i>
                                                <div class="twm-title">İş
                                                    rejimi: {{ $job['jobType']['name']['az'] ?? 'Qeyd edilməyib' }}</div>
                                            </li>
                                            <li>
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="twm-title">
                                                    Şəhər/Rayon: {{ $job['city']['name']['az'] ?? 'Qeyd edilməyib' }}</div>
                                            </li>
                                            <li>
                                                <i class="fas fa-money-bill-wave"></i>
                                                <div class="twm-title">Maaş: {{$job['price']}}</div>
                                            </li>
                                            <li>
                                                <i class="fas fa-eye"></i>
                                                <div class="twm-title">{{ ($job['reads'] ?? 0) * 5 }} Baxış</div>
                                            </li>
                                            <li>
                                                <i class="fas fa-file-signature"></i>
                                                <div class="twm-title">{{ count($job['jobContact']) ?? 0 }} Müraciət
                                                    edən
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <!-- OUR BLOG END -->


    </div>
    <!--apply job popup -->
    <div class="modal fade" id="apply_job_popup" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="sign_up_popupLabel">{{ $job['title']['az'] }} - elanı üçün müraciət
                        edin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="apl-job-inpopup">
                        <!--Basic Information-->
                        <div class="panel panel-default">

                            <div class="panel-body wt-panel-body p-a20 ">

                                <div class="twm-tabs-style-1">
                                    <div id="form-messages"></div>
                                    <form enctype="multipart/form-data">
                                        <input type="hidden" name="job_id" id="job_id" value="{{$job['id']}}">
                                        <input type="hidden" name="company_id" id="company_id"
                                               value="{{$job['company_id']}}">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Ad soyad</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="fullname" id="fullname"
                                                               type="text">
                                                        <i class="fs-input-icon fa fa-user"></i>
                                                    </div>
                                                    <small class="text-danger error-message"
                                                           id="fullname-error"></small>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>E-poçt</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="email" id="email"
                                                               type="email">
                                                        <i class="fs-input-icon fas fa-at"></i>
                                                    </div>
                                                    <small class="text-danger error-message" id="email-error"></small>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Əlaqə vasitəsi</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="phone" id="phone" type="text">
                                                        <i class="fs-input-icon fas fa-phone"></i>
                                                    </div>
                                                    <small class="text-danger error-message" id="phone-error"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <style>
                                                    .custom-file-upload {
                                                        position: relative;
                                                        display: inline-block;
                                                        padding: 12px 20px;
                                                        background-color: #f3f6ff;
                                                        color: #333;
                                                        border: 2px dashed #cdd6f3;
                                                        border-radius: 12px;
                                                        cursor: pointer;
                                                        width: 100%;
                                                        text-align: center;
                                                        font-weight: 500;
                                                        transition: all 0.3s ease;
                                                    }

                                                    .custom-file-upload:hover {
                                                        background-color: #e1e9ff;
                                                    }

                                                    .custom-file-upload i {
                                                        margin-right: 8px;
                                                    }

                                                    #resume {
                                                        display: none;
                                                    }

                                                    #file-name {
                                                        display: block;
                                                        margin-top: 10px;
                                                        font-style: italic;
                                                        color: #666;
                                                    }
                                                </style>

                                                <div class="form-group">
                                                    <label>CV yüklə</label>
                                                    <label for="resume" class="custom-file-upload">
                                                        <i class="fas fa-upload"></i> Fayl seç
                                                    </label>
                                                    <input class="form-control" name="resume" id="resume" type="file"
                                                           accept=".pdf,.doc,.docx">
                                                    <span id="file-name">Heç bir fayl seçilməyib</span>
                                                    <small class="text-danger error-message" id="resume-error"></small>
                                                </div>

                                                {{--                                                <div class="form-group">--}}
                                                {{--                                                    <label>CV yüklə</label>--}}
                                                {{--                                                    <div class="ls-inputicon-box">--}}
                                                {{--                                                        <input class="form-control" name="resume" id="resume" type="file" accept=".pdf,.doc,.docx">--}}
                                                {{--                                                        <i class="fs-input-icon fas fa-file-upload"></i>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <small class="text-danger error-message" id="resume-error"></small>--}}
                                                {{--                                                    <br>--}}
                                                {{--                                                    <small>Yalnız və yalnız word, pdf formatları yüklənə bilər</small>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Motivasiya mektubu</label>
                                                    <textarea class="form-control" name="messages" id="messages"
                                                              rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="text-left">
                                                    <button type="submit" class="site-button">Müraciətinizi göndərin</button>
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
        </div>

    </div>
@endsection
@section('web.js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            const formMessages = document.getElementById("form-messages");

            form.addEventListener("submit", function (e) {
                e.preventDefault();

                // Təmizlə
                formMessages.innerHTML = "";
                document.querySelectorAll(".form-control").forEach(input => {
                    input.classList.remove("is-invalid");
                });
                document.querySelectorAll(".error-message").forEach(el => {
                    el.innerText = "";
                });

                const formData = new FormData(form);

                fetch("https://isveren.az/job-contact/", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            formMessages.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                            form.reset();
                        } else if (data.error) {
                            // Input səhvləri
                            Object.keys(data.error).forEach(key => {
                                const input = document.getElementById(key);
                                const errorContainer = document.getElementById(`${key}-error`);
                                if (input) input.classList.add("is-invalid");
                                if (errorContainer) errorContainer.innerText = data.error[key][0];
                            });
                        } else {
                            // Ümumi xəta
                            formMessages.innerHTML = `<div class="alert alert-danger">${data.message || "Xəta baş verdi."}</div>`;
                        }
                    })
                    .catch(error => {
                        formMessages.innerHTML = `<div class="alert alert-danger">Server xətası baş verdi.</div>`;
                        console.error("Error:", error);
                    });
            });
        });
    </script>
    <script>
        document.getElementById("resume").addEventListener("change", function () {
            const fileName = this.files[0] ? this.files[0].name : "Heç bir fayl seçilməyib";
            document.getElementById("file-name").textContent = fileName;
        });
    </script>


    <script>
        const pageUrl = encodeURIComponent(window.location.href);
        const pageTitle = encodeURIComponent(document.title);

        document.getElementById("share-facebook").href =
            `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;

        document.getElementById("share-linkedin").href =
            `https://www.linkedin.com/shareArticle?mini=true&url=${pageUrl}&title=${pageTitle}`;

        document.getElementById("share-whatsapp").href =
            `https://wa.me/?text=${pageTitle}%20${pageUrl}`;
    </script>

@endsection
