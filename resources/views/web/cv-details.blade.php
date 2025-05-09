@extends('web.layouts.app')
@section('site.title')
    CV haqqda ətraflı məlumat
@endsection
@section('web.css')
    <meta http-equiv="content-language" content="az">
    <meta name="title" content="isveren.az - {{ $data['name'] }} {{ $data['surname'] }} CV | Azərbaycanda İşəgötürənlər üçün Ən Yaxşı Platforma">
    <meta name="description" content="{{ $data['name'] }} {{ $data['surname'] }} - {{ json_decode($data->profession, true)['title']['az'] ?? '' }}. Təcrübə, təhsil və digər məlumatlar isveren.az saytında." />
    <meta property="og:title" content="isveren.az - {{ $data['name'] }} {{ $data['surname'] }} CV | Azərbaycanda İşəgötürənlər üçün Ən Yaxşı Platforma" />
    <meta name="og:description" content="{{ $data['name'] }} {{ $data['surname'] }} - {{ json_decode($data->profession, true)['title']['az'] ?? '' }}. Təcrübə, təhsil və digər məlumatlar isveren.az saytında." />
    <meta property="og:url" content="https://isveren.az/cv/{{ $data['id'] }}" />
    <meta name="keywords" content="{{ $data['name'] }} {{ $data['surname'] }}, CV, isveren.az, {{ json_decode($data->profession, true)['title']['az'] ?? '' }}, vakansiyalar, iş elanları, iş tapmaq" />

    <meta name="og:image" content="{{ asset('web/assets/img/favicon.png') }}">
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
@endsection
@section('web.section')

<div class="page-content">
    <!-- Candidate Detail V2 START -->
    <div class="section-full p-b90 bg-white">
        <div class="twm-candi-self-wrap-2 overlay-wraper" style="background-image:url({{ asset('site/images/candidates/candidate-bg2.jpg') }});">
            <div class="overlay-main site-bg-primary opacity-01"></div>
            <div class="container">
                <div class="twm-candi-self-info-2">
                    <div class="twm-candi-self-top">
                        <?php
                        $job_status = '';
                        if($data['is_premium'] ==1){
                            $job_status = 'Premium';
                        }elseif ($data['is_new'] ==1) {
                            $job_status = 'Yeni';
                        }elseif ($data['is_top'] ==1) {
                            $job_status = '';
                        }
                        ?>
                        @if($job_status != '')
                        <div class="twm-candi-fee">{{$job_status}}</div>
                        @endif
                        @if(!empty($data['user']['image']))
                        <div class="twm-media" style="max-width: 101px; border-radius: 34px;">
                            <img src="{{ asset('uploads/user/userlogo/'.$data['user']['image']) }}" alt="#">
                        </div>
                        @endif
                        <div class="twm-mid-content">

                            <h4 class="twm-job-title">{!! $data['user']['name'] !!} {!! $data['user']['surname'] !!}</h4>
                            <p>{!! $data['title'] !!}</p>
                            <p class="twm-candidate-address"><i class="feather-map-pin"></i>{!! $data['actual_address'] !!}</p>

                        </div>
                    </div>
                    {{--<div class="twm-ep-detail-tags">
                        <button class="de-info twm-bg-green"><i class="fa fa-share-alt"></i> Share</button>
                        <button class="de-info twm-bg-brown"><i class="fa fa-file-signature"></i> Shortlist</button>
                        <button class="de-info twm-bg-purple"><i class="fa fa-exclamation-triangle"></i> Report</button>
                        <button class="de-info twm-bg-sky"><i class="fa fa-save"></i> Save</button>
                    </div>--}}
                    @if(!empty($data['resume']))
                    <div class="twm-candi-self-bottom">
                        <a ></a>
                        <a href="{{ asset('uploads/user/resume/'.$data['resume']) }}" class="site-button secondry" download="download">CV yüklə</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">


            <div class="section-content">

                <div class="row d-flex justify-content-center">

                    <div class="col-lg-9 col-md-12">
                        <!-- Candidate detail START -->
                        <div class="cabdidate-de-info">

                            <div class="twm-s-info-wrap mb-5">
                                <h4 class="section-head-small mb-4">Ətraflı məlumat</h4>
                                <div class="twm-s-info-4">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Əsas kateqorya</span>
                                                <div class="twm-s-info-discription">{{$data['category']['name']['az'] ?? '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Kateqorya</span>
                                                <div class="twm-s-info-discription">{{$data['parentCategory']['name']['az'] ?? '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-clock"></i>
                                                <span class="twm-title">İş rejimi</span>
                                                <div class="twm-s-info-discription">{{ $data['workingHour']['name']['az'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span class="twm-title">Maaş istəyi</span>
                                                <?php
                                                    $salary = 'Qeyd edilməyib';
                                                    if (!empty($data['min_salary']) && empty($data['max_salary'])) {
                                                        $salary = $data['min_salary'].'+'. 'AZN';
                                                    } elseif (!empty($data['min_salary']) && !empty($data['max_salary'])) {
                                                        $salary = $data['min_salary'].'-'. $data['max_salary']. 'AZN';
                                                    } elseif (empty($data['min_salary']) && !empty($data['max_salary'])) {
                                                        $salary = $data['max_salary']. 'AZN';
                                                    }
                                                ?>
                                                <div class="twm-s-info-discription">{{ $salary }} </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Ölkə</span>
                                                <div class="twm-s-info-discription">{{json_decode($data['country']['name'])->az ?? '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Şəhər</span>
                                                <div class="twm-s-info-discription">{{$data['city']['name']['az'] ?? '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span class="twm-title">Əlaqə nömrəsi</span>
                                                <div class="twm-s-info-discription">{{$data['phone'] ?? '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-at"></i>
                                                <span class="twm-title">E-poçt</span>
                                                <div class="twm-s-info-discription">{{$data['email'] ?? '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Evlilik statusu</span>
                                                <?php
                                                    $marriedStatus = '';
                                                    $isChild = '';
                                                    if ($data['married_status']!=1){
                                                        $marriedStatus = 'Evli';
                                                            if($data['is_child'] ==1){
                                                                $isChild = 'Uşaq var';
                                                            }else{
                                                                $isChild = 'Uşaq yoxdur';
                                                            }
                                                    }else{
                                                        $marriedStatus = 'Subay';
                                                    }
                                                ?>
                                                <div class="twm-s-info-discription">{{$marriedStatus}} {{!empty($isChild)? '-'.$isChild:''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-venus-mars"></i>
                                                <span class="twm-title">Cins</span>
                                                <div class="twm-s-info-discription">{{$data['gender_status']==1?'Kişi':'Qadın'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="twm-s-info-inner">

                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="twm-title">Qeydiyyat ünvanı</span>
                                                <div class="twm-s-info-discription">{!! $data['permanent_address'] ?? '-' !!}</div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @if(!empty($data['note']) && $data['note']!='0')
                            <h4 class="twm-s-title m-t0">Haqqında</h4>


                            <p>{!! $data['note'] !!}</p>
                            @endif
                            @if(!empty(json_decode($data['skills'],1)[0]))
                            <h4 class="twm-s-title">Biliklər</h4>
                            <div class="tw-sidebar-tags-wrap">
                                <div class="tagcloud">
                                    @foreach(json_decode($data['skills'],1) as $skill)
                                     <a href="javascript:void(0)">{{$skill}}</a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if(!empty(json_decode($data['language'],1)[0]))
                            <h4 class="twm-s-title">Dil bilikləri</h4>
                            <div class="tw-sidebar-tags-wrap">
                                <div class="tagcloud">
                                    @foreach(json_decode($data['language'],1) as $lang)
                                            <?php
                                            if($lang['currentlyWorked'] == 'excellent'){
                                                $currentlyWorked = 'Əla';
                                            }elseif($lang['currentlyWorked'] == 'average'){
                                                $currentlyWorked = 'Orta';
                                            }else {
                                                $currentlyWorked = 'Zəif';
                                            }
                                            ?>
                                     <a href="javascript:void(0)">{{$lang['name']}} -{{$currentlyWorked}}</a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if(!empty(json_decode($data['experience'],1)[0]['company']))
                            <h4 class="twm-s-title">İş Təcrübəsi</h4>
                            <div class="twm-timing-list-wrap">
                                @foreach(json_decode($data['experience'],1) as $experience)
                                <div class="twm-timing-list">
                                    <div class="twm-time-list-date">{{$experience['skill_start_date']}} - {{!empty($experience['currentlyWorked'])? 'Isleyir':$experience['skill_end_date']}}</div>
                                    <div class="twm-time-list-title">{{$experience['company']}}</div>
                                    <div class="twm-time-list-position">{{$experience['position']}}</div>
                                    <div class="twm-time-list-discription">
                                        <p>{{$experience['skill_text']}}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @if(!empty(json_decode($data['education'],1)[0]))
                                <h4 class="twm-s-title">Təhsil</h4>
                                <div class="twm-timing-list-wrap">
                                    @foreach(json_decode($data['education'],1) as $education)
                                        <div class="twm-timing-list">
                                            <div class="twm-time-list-date">{{$education['education_start_date']}} - {{!empty($education['currentlyStudying'])? 'Oxuyur':$education['education_end_date']}}</div>
                                            <div class="twm-time-list-title">{{$education['name']}}</div>
                                            <div class="twm-time-list-position">{{$education['specialization']}}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- Candidate Detail V2 END -->
</div>
@endsection
@section('web.js')
@endsection
