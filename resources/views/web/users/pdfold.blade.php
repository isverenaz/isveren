<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{$data['name']}} {{$data['surname']}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 150px;
            border-radius: 50%;
        }
        .header h1 {
            margin: 10px 0;
        }
        .header p {
            font-size: 14px;
            color: #777;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .section h2 {
            margin-top: 0;
        }
        .skills-list, .education-list, .experience-list {
            list-style-type: none;
            padding: 0;
        }
        .skills-list li, .education-list li, .experience-list li {
            background-color: #f7f7f7;
            margin-bottom: 5px;
            padding: 10px;
            border-radius: 4px;
        }
        .contact-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ !empty($data['image']) ? asset('uploads/cv/'.$data['image']) : asset('user/user.png') }}" alt="Profile Picture">
    <h1>{{$data['name']}} {{$data['surname']}}</h1>
    <p>{{ json_decode($data->profession, true)['title']['az'] }}</p>
</div>
@if(!empty(json_decode($data['description'],true)['az']))
<div class="section">
    <h2>Haqqında</h2>
    <p>{!! json_decode($data['description'],true)['az'] !!}</p>
</div>
@endif
<div class="section">
    <h2>İş bilikləri</h2>
    <ul class="skills-list">
        @if(!empty($data['work_skills']))
            @foreach($data['work_skills'] as $skill)
                <li>{!! $skill !!}</li>
            @endforeach
        @else
            <li>İş bilikləri yoxdur</li>
        @endif
    </ul>
</div>

<div class="section">
    <h2>Dil bilikləri</h2>
    <ul class="skills-list">
        @if(!empty($data['language_skills']))
            @foreach($data['language_skills'] as $skill)
                <li>
                    @if($skill['lang'] == 1) Azərbaycan dili
                    @elseif($skill['lang'] == 2) Rus dili
                    @elseif($skill['lang'] == 3) İngilis dili
                    @elseif($skill['lang'] == 4) Türk dili
                    @elseif($skill['lang'] == 5) Alman dili
                    @elseif($skill['lang'] == 6) Fransız dili
                    @elseif($skill['lang'] == 7) İspan dili
                    @elseif($skill['lang'] == 8) Çin dili (Mandarin)
                    @elseif($skill['lang'] == 9) Ərəb dili
                    @elseif($skill['lang'] == 10) Portuqal dili
                    @endif
                    - {{ $skill['levels'] == 1 ? 'Zəif' : ($skill['levels'] == 2 ? 'Orta' : ($skill['levels'] == 3 ? 'Yaxşı' : 'Əla')) }}
                </li>
            @endforeach
        @else
            <li>Dil bilikləri yoxdur</li>
        @endif
    </ul>
</div>

<div class="section">
    <h2>İş təcrübəsi</h2>
    <ul class="experience-list">
        @if(!empty($data['work_experience']))
            @foreach($data['work_experience'] as $experience)
                <li>{!! $experience['company'] !!} - {!! $experience['position'] !!} | {{ date('d.m.Y', strtotime($experience['start_date'])) }} - {{ !empty($experience['end_date']) ? date('d.m.Y', strtotime($experience['end_date'])) : 'Hal-hazırda işləyir' }}</li>
            @endforeach
        @else
            <li>İş təcrübəsi yoxdur</li>
        @endif
    </ul>
</div>

<div class="section">
    <h2>Təhsil</h2>
    <ul class="education-list">
        @if(!empty($data['education']))
            @foreach($data['education'] as $education)
                <li>{!! $education['name'] !!} - {!! $education['specialty_name'] !!} ({{ date('Y', strtotime($education['start_date'])) }} - {{ !empty($education['end_date']) ? date('Y', strtotime($education['end_date'])) : 'Hal-hazırda oxuyur' }})</li>
            @endforeach
        @else
            <li>Təhsili yoxdur</li>
        @endif
    </ul>
</div>

<div class="section contact-info">
    <h2>Əlaqə vasitəsi</h2>
    <p><strong>Telefon:</strong> {{$data['phone']}}</p>
    <p><strong>Email:</strong> <a href="mailto:{{$data['email']}}">{{$data['email']}}</a></p>
</div>

</body>
</html>
