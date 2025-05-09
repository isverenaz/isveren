@php use Illuminate\Support\Carbon; @endphp

@foreach ($companies as $key => $data)
        <?php
        $datePosted = isset($data->start_date) ? date('Y-m-d', strtotime($data->start_date)) : null;
        if (empty($datePosted)){
            $datePosted = isset($data->created_at)? date('Y-m-d', strtotime($data->created_at)) : null;
        }

        $job_status = '';
        if($data['is_premium'] ==1){
            $job_status = 'premium-job';
        }elseif ($data['is_premium'] !=1 && !empty($datePosted) && $datePosted == Carbon::now()->toDateString()) {
            $job_status = 'new-job';
        }elseif ($data['is_top'] ==1) {
            $job_status = '';
        }
        $date = new DateTime($datePosted);
        $now = new DateTime();
        $diff = $now->diff($date);

        if ($diff->invert === 0) {
            // Gələcək tarixlər üçün yoxlama (əgər gələcək tarixdirsə)
            $created_at = "Gələcək tarix";
        } elseif ($diff->y >= 1 || $diff->m >= 1 || $diff->d > 2) {
            // 2 gündən çox keçibsə normal tarix formatı
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
        }/* elseif ($diff->d == 2) {
            $created_at = "2 gün əvvəl";
        } */elseif ($diff->d == 1) {
            $created_at = "Dünən";
        } elseif ($diff->h >= 1) {
            $created_at = $diff->h . " saat öncə";
        } elseif ($diff->i >= 1) {
            $created_at = $diff->i . " dəqiqə öncə";
        } elseif ($diff->s >= 3) {
            $created_at = $diff->s . " saniyə öncə";
        } else {
            $created_at = "İndicə";
        }

        ?>
    <li class="job-item {{$job_status}}">
        <div class="job-logo">
            @if($data['logo'] && $data['logo'] !='null.png')
                <img alt="" src="{{ asset("uploads/companies/logo/".$data['logo']) }}"
                    {{--style="width: 100px !important; border-radius: 0%;"--}} style="object-fit: contain;!important;">
            @else
                    <?php
                    $company_name = $data['name']['az'] ?? "$";
                    $first = substr(trim($company_name),0,1);
                    if ($first == '"'){ $first = substr(trim($company_name),1,2);}
                    ?>
                <div class="vacancies__icon" data-color="#4B21F3">
                    <div class="vc_icon_back" style="background-color:#4B21F3;"></div>
                    <span style="color:#4B21F3 !important;"> {{$first}} </span>
                </div>
            @endif
        </div>
        <div class="job-details">
            <p class="job-title"><a href="{{ route('web.company-details',$data['id']) }}" target="_blank">{!! $data['name']['az'] !!}</a></p>
            <div class="job-meta">
                <p class="job-company">{!! $data['address']['az'] !!}
                    şəbəkəsi</p>
                <div class="job-stats">
                    <span class="views">👁️‍🗨️ {{($data['reads'] ?? 0) * 5}}</span>
                    <span>|</span>
                    <span class="views">🕒 {{$created_at}}</span>
                </div>
            </div>
        </div>
    </li>
@endforeach
{{--<li class="job-item">
    <a href="@lang('web.telegram')" target="_blank" class="job-details">
        <img data-v-50066f1e="" src="https://storage.jobsearch.az/storage/pages/1/telegram-0-12.png" alt="">
    </a>
</li>--}}
