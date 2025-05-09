@php use Illuminate\Support\Carbon; @endphp
@if(!empty($cv))
    @foreach($cv as $data)
        <li>
                <?php
                $datePosted = isset($data->created_at)? date('Y-m-d', strtotime($data->created_at)) : null;

                $job_status = '';
                if($data['is_premium'] ==1){
                    $job_status = 'premium-job';
                }elseif ($data['is_premium'] !=1 && !empty($datePosted) && $datePosted == Carbon::now()->toDateString()) {
                    $job_status = 'new-job';
                }elseif ($data['is_top'] ==1) {
                    $job_status = '';
                }
                ?>
            <div class="twm-candidates-list-style1 mb-5 {{$job_status}}">
                <div class="twm-media">
                    <div class="twm-media-pic">
                        @if(empty($data['user']['image']))
                            <img src="{{ asset("site\img\user.png") }}" alt="">
                        @else
                            <img src="{{ asset("uploads/user/userlogo/".$data['user']['image']) }}" alt="">
                        @endif
                    </div>
                    <div class="twm-candidates-tag"><span>{{$data['workingHour']['name']['az'] ?? '-'}}</span></div>
                </div>
                <div class="twm-mid-content">
                    <a href="{{ route('web.cv-details', ['slug' => $data['slug'], 'id' =>$data['id']]) }}" class="twm-job-title">
                        <h4>{{ $data['user']['name'] }} {{ $data['user']['surname'] }}</h4>
                    </a>
                    <p>{!! $data['title'] !!}</p>

                    <div class="twm-fot-content">
                        <div class="twm-left-info">
                            <p class="twm-candidate-address"><i class="feather-map-pin"></i>{{$data['city']['name']['az']}}</p>
                            <div class="twm-jobs-vacancies"><span>{{$data['min_salary'] ?? '-'}}</span><span>- {{$data['max_salary'] ?? '+'}} AZN </span></div>
                            <div class="twm-jobs-vacancies"><span class="views"> 👁️‍🗨️ {{$data['reads'] * 5 }}</span></div>
                        </div>
                        <div class="twm-right-btn">
                            <a href="{{ route('web.cv-details', ['slug' => $data['slug'], 'id' =>$data['id']]) }}" class="twm-view-prifile site-text-primary">Ətraflı</a>
                        </div>
                    </div>
                </div>

            </div>
        </li>
    @endforeach
@endif
