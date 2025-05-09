@foreach ($blogs as $data)
    <div class="col-lg-4 col-md-6" itemscope itemtype="https://schema.org/BlogPosting">
        <div class="top-company-item mb-4">
            <div class="top-company-image rounded overflow-hidden position-relative">
                <img src="{{ asset('uploads/blogs/'.$data->image) }}" alt="{!! json_decode($data, true)['title']['az'] !!}" style="max-height: 246px; min-height: 246px;!important;">
                <p class="bg-theme mb-2 rounded p-2 px-3 d-inline-block white position-absolute bottom-0 start-0 ms-3">
                    {!! json_decode($data->jobcategory, true)['name']['az'] !!}</p>
            </div>
            <div class="top-company-content-main pt-3">
                <div class="top-company-content">
                    <h4 class="border-b mb-2 pb-2"><a href="{{ route('web.blogs-details',$data->id) }}">{!! json_decode($data, true)['title']['az'] !!}</a></h4>
                    <div class="entry-meta d-flex align-items-center justify-content-between">
                        <div class="entry-author mb-2 d-flex align-items-center">
                            <div class="entry-content">
                                <p class="mb-0 theme2">{!! $data->user->name !!} {!! $data->user->surname !!}</p>
                                    <?php
                                    $dateString = $data->created_at;
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
                                    $formattedDate = $date->format('d ') .' '. $months[(int)$date->format('m')];
                                    ?>
                                <span
                                        style="margin-right:15px;  padding-top: 5px; font-size:14px;">{{ $formattedDate }}</span>
                            </div>
                        </div>
                        <div class="entry-button mb-2">
                            <small> <i class="fa fa-eye"></i> {{$data->reads}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BlogPosting",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ route('web.blogs-details', $data->id) }}"
        },
        "headline": "{{ json_decode($data, true)['title']['az'] }}",
        "image": "{{ asset('uploads/blogs/'.$data->image) }}",
        "author": {
            "@type": "Person",
            "name": "{{ $data->user->name }} {{ $data->user->surname }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "{{ config('app.name') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('path_to_logo_image') }}"
            }
        },
        "datePublished": "{{ $date->format('Y-m-d') }}",
        "dateModified": "{{ $date->format('Y-m-d') }}",
        "articleSection": "{{ json_decode($data->jobcategory, true)['name']['az'] }}",
        "interactionCount": "{{ $data->reads }}"
    }
    </script>
@endforeach
