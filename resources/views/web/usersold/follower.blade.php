@extends('web.users.user-menu')
@section('user.css')
    <style>
        .active-like {
            display: flex;
            align-items: center;
            justify-content: end;
            padding-top: 2px;
            margin-left: 25px;
            border-radius: 12px;
            color: #061e40;
            width: 40px;
            height: 40px;
            /*margin-right: 9px;*/
            /*background-color: #f3f6f9;*/
            /*position: absolute;*/
            /*right: 25px;*/
            /*bottom: 15px;*/
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
            display: flex;
            align-items: center;
            justify-content: end;
            padding-top: 2px;
            margin-left: 25px;
            border-radius: 12px;
            color: #061e40;
            width: 40px;
            height: 40px;
            /*margin-right: 9px;*/
            /*background-color: #f3f6f9;*/
            /*position: absolute;*/
            /*right: 25px;*/
            /*bottom: 15px;*/
        }

        .active-dislike {
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 8px;
            background-image: url("{{ asset('web/assets/images/heart-like.png') }}");

            background-size: 18px;
            opacity: 1;
        }


    </style>
@endsection
@section('user.section')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">@lang('web.followers')</h4>
                    </div>
                </div>
            </div>
            @if ( Session::get('errors'))
                <div class="col-12 mt-1">
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">{{ Session::get('errors') }}</div>
                    </div>
                </div>
            @endif
            @if (Session::get('success'))
                <div class="col-12 mt-1">
                    <div class="alert alert-success" role="alert">
                        <div class="alert-body">{{ Session::get('success') }}</div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1" style="color: #0ad60a;">
                                    @lang('web.jobs_count'): @if(!empty($jobs)) {{$jobs->count()}} @else 0 @endif</h5>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('web.user.follower') }}" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                @if($jobs->isNotEmpty())
                                    <table class="table table-bordered align-middle nowrap">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('web.company')</th>
                                            <th scope="col">@lang('web.title')</th>
                                            <th scope="col">@lang('web.salary')</th>
                                            <th scope="col">@lang('web.updated_at')</th>
                                            <th scope="col">@lang('web.status')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($jobs as $key => $item)
                                            <tr>
                                                <th scope="row">{{++$key}}</th>
                                                <td>{!! json_decode($item->company, true)['name']['az'] ?? null !!}</td>
                                                <td>{!! json_decode($item, true)['title']['az'] ?? null !!}</td>
                                                <td>{!! $item->price ?? '-' !!}</td>
                                                <td>{{ date('d.m.Y',strtotime($item->updated_at)) }}</td>
                                                <td>
                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Beyenmeden cixar">
                                                            @php
                                                                $userInteraction = auth('web')
                                                                    ->user()
                                                                    ->followers()
                                                                    ->where('job_id', $item->job_id)
                                                                    ->first();

                                                                $defaultInteractionType = $userInteraction->interaction_type ?? null;
                                                            @endphp
                                                            <a href="javascript:void(0)" data-job-id="{{ $item->job_id }}"
                                                               class="interaction-button {{ $defaultInteractionType === 'like' ? 'active-dislike' : 'active-like' }}"
                                                               data-job-id="{{ $item->job_id }}" id="test"></a>
                                                        </li>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Etrafli">
                                                            <a href="{{ route('web.job-details',$item->job_id) }}" class="btn btn-sm btn-soft-info">
                                                                <i class="mdi mdi-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div style="text-align: center;color: red;">
                                        <h3>@lang('web.not_jobs_list')</h3>
                                    </div>
                                @endif
                            </div>
                            @if($jobs->isNotEmpty())
                                <div class="row justify-content-between align-items-center">

                                    <div class="col-auto">
                                        <div class="card d-inline-block ms-auto mb-0">
                                            <div class="card-body p-2">
                                                <nav aria-label="Page navigation example" class="mb-0">
                                                    <ul class="pagination mb-0">
                                                        {{ $jobs->links() }}
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('user.js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.interaction-button').on('click', function() {

                let button = $(this);
                let jobId = button.data('job-id');
                let interactionType = '';

                if (button.hasClass('active-like')) {
                    interactionType = 'like';
                } else if (button.hasClass('active-dislike')) {
                    interactionType = 'dislike';
                }

                disablePost = true;

                $.ajax({
                    type: 'POST',
                    url: '/interact',
                    data: {
                        job_id: jobId,
                        interaction: interactionType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        let interactionType = data.interaction;
                        console.log(interactionType);

                        button.removeClass('active-like active-dislike');

                        if (interactionType === 'like') {
                            button.attr('class', 'interaction-button active-dislike');
                        } else if (interactionType === 'dislike') {
                            button.attr('class', 'interaction-button active-like');
                        }

                        disablePost = false;
                    }
                });
            });
        });
    </script>
@endsection
