@extends('web.users.user-menu')
@section('user.css')
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
@endsection
@section('user.section')
    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
        <div class="twm-jobs-list-wrap">
            <ul class="job-list">
                @if(!empty($jobs[0]))
                    @foreach($jobs as $job)
                        @if(!empty($job['job']['id']))
                            <li class="job-item @if($job['job']['is_premium']==1) premium-job @elseif($job['job']['is_new']==1) new-job @else @endif">
                            <div class="job-logo">
                                @if($job['company']['logo'] && $job['company']['logo'] !='null.png')
                                    <img alt="" src="{{ asset("uploads/companies/logo/".$job['company']['logo']) }}">
                                @else
                                        <?php
                                        $company_name = $job['company']['name']['az'] ?? "$";
                                        $first = substr(trim($company_name),0,1);
                                        if ($first == '"'){ $first = substr(trim($company_name),1,2);}
                                        ?>
                                    <div class="vacancies__icon" data-color="#4B21F3">
                                        <div class="vc_icon_back" style="background-color:#4B21F3;"></div>
                                        <span style="color:#4B21F3 !important;"> {{$first}} </span>
                                    </div>
                                @endif
{{--                                <img src="https://isveren.az/uploads/companies/logo/%22adore-kompani%22-mmc.webp" alt="Company Logo">--}}
                            </div>
                            <div class="job-details">
                                <p class="job-title">{{ $job['job']['title']['az'] ?? null }}</p>
                                <div class="job-meta">
                                    <p class="job-company">{{ $job['job']['company']['name']['az'] ?? null }}</p>
                                    <div class="job-stats">
                                        <span class="views">👁️ {{ $job['job']['reads'] ?? 0}}</span>
                                        <span>|</span>
                                            <?php
                                            $datePosted = isset($job['job']->created_at) ? date('Y-m-d',strtotime($job['job']->created_at)) : \Carbon\Carbon::now();
                                            $date = new DateTime($datePosted);
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
                                            ?>
                                        <span class="views">🕒 {{$created_at}}</span>
                                        <div class="twm-table-controls">
                                            <ul class="twm-DT-controls-icon list-unstyled">
                                                <li>
                                                    <a href="{{ asset('uploads/job-contact/'.$job['resume']) }}" title="CV yüklə" target="blank" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fa fa-download"></i></a>
                                                </li>
                                                {{--<li>
                                                    <a data-bs-toggle="modal" href="#jobsDelete" role="button" class="custom-toltip">
                                                        <span class="fa fa-trash-alt"></span>
                                                        <span class="custom-toltip-block"></span>
                                                    </a>
                                                </li>--}}
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>
                        @else
                            <li class="job-item">
                                <div class="job-details">
                                    <p class="job-title">Heç bir müraciətiniz tapılmadı!</p>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>

        @if ($jobs->lastPage() > 1)
            <div class="pagination-outer" style="display: flex; justify-content: center">
                <div class="pagination-style1">
                    <ul class="clearfix">
                        {{-- Əvvəlki səhifə --}}
                        <li class="prev {{ $jobs->currentPage() == 1 ? 'disabled' : '' }}">
                            <a href="{{ $jobs->previousPageUrl() }}">
                                <span><i class="fa fa-angle-left"></i></span>
                            </a>
                        </li>

                        {{-- İlk səhifə --}}
                        <li class="{{ $jobs->currentPage() == 1 ? 'active' : '' }}">
                            <a href="{{ $jobs->url(1) }}">1</a>
                        </li>

                        {{-- Üç nöqtə (əgər lazımdırsa) --}}
                        @if ($jobs->currentPage() > 3)
                            <li>
                                <a href="javascript:;"><i class="fa fa-ellipsis-h"></i></a>
                            </li>
                        @endif

                        {{-- Aralıq səhifələr --}}
                        @for ($i = max(2, $jobs->currentPage() - 1); $i <= min($jobs->lastPage() - 1, $jobs->currentPage() + 1); $i++)
                            <li class="{{ $jobs->currentPage() == $i ? 'active' : '' }}">
                                <a href="{{ $jobs->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Üç nöqtə (əgər lazımdırsa) --}}
                        @if ($jobs->currentPage() < $jobs->lastPage() - 2)
                            <li>
                                <a href="javascript:;"><i class="fa fa-ellipsis-h"></i></a>
                            </li>
                        @endif

                        {{-- Son səhifə --}}
                        @if ($jobs->lastPage() > 1)
                            <li class="{{ $jobs->currentPage() == $jobs->lastPage() ? 'active' : '' }}">
                                <a href="{{ $jobs->url($jobs->lastPage()) }}">{{ $jobs->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Sonrakı səhifə --}}
                        <li class="next {{ $jobs->currentPage() == $jobs->lastPage() ? 'disabled' : '' }}">
                            <a href="{{ $jobs->nextPageUrl() }}">
                                <span><i class="fa fa-angle-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif

        <div class="modal fade twm-saved-jobs-view" id="jobsDelete" aria-hidden="true" aria-labelledby="sign_up_popupLabel-3" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title">Do you want to delete your profile?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="site-button" data-bs-dismiss="modal">No</button>
                        <button type="button" class="site-button outline-primary">Yes</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('user.js')
@endsection
