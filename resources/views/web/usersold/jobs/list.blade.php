@extends('web.users.user-menu')
@section('user.css')
@endsection
@section('user.section')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">@lang('web.jobs_list')</h4>
                    </div>
                </div>
            </div>
            @include('components.web.error')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1" style="color: #0ad60a;">
                                    @lang('web.jobs_count'): @if($jobs->isNotEmpty()) {{$jobs->count()}} @else 0 @endif</h5>
                                <div class="flex-shrink-0">
                               <a href="{{ route('web.user.jobs.create') }}" class="btn btn-primary">@lang('web.jobs_add')</a>
                                    <a href="{{ route('web.user.jobs.list') }}" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                </div>
                            </div>
                        </div>
{{--                        <div class="card-body border-bottom">--}}
{{--                            <div class="row g-3">--}}
{{--                                <div class="col-xxl-4 col-lg-6">--}}
{{--                                    <input type="search" class="form-control" id="searchInput"--}}
{{--                                           placeholder="Search for ...">--}}
{{--                                </div>--}}
{{--                                <div class="col-xxl-2 col-lg-6">--}}
{{--                                    <select class="form-control select2">--}}
{{--                                        <option>Status</option>--}}
{{--                                        <option value="Active">Active</option>--}}
{{--                                        <option value="New">New</option>--}}
{{--                                        <option value="Close">Close</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-xxl-2 col-lg-4">--}}
{{--                                    <select class="form-control select2">--}}
{{--                                        <option>Select Type</option>--}}
{{--                                        <option value="1">Full Time</option>--}}
{{--                                        <option value="2">Part Time</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-xxl-2 col-lg-4">--}}
{{--                                    <div id="datepicker1">--}}
{{--                                        <input type="text" class="form-control" placeholder="Select date"--}}
{{--                                               data-date-format="dd M, yyyy" data-date-autoclose="true"--}}
{{--                                               data-date-container='#datepicker1' data-provide="datepicker">--}}
{{--                                    </div><!-- input-group -->--}}
{{--                                </div>--}}
{{--                                <div class="col-xxl-2 col-lg-4">--}}
{{--                                    <button type="button" class="btn btn-soft-secondary w-100"><i--}}
{{--                                            class="mdi mdi-filter-outline align-middle"></i> Filter--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="card-body">

                            <div class="table-responsive">
                                @if($jobs->isNotEmpty())
                                <table class="table table-bordered align-middle nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('web.title')</th>
                                        <th scope="col">@lang('web.category')</th>
                                        <th scope="col">@lang('web.location')</th>
                                        <th scope="col">@lang('web.salary')</th>
                                        <th scope="col">@lang('web.type')</th>
                                        <th scope="col">@lang('web.created_at')</th>
                                        <th scope="col">@lang('web.updated_at')</th>
                                        <th scope="col">@lang('web.status')</th>
                                        <th scope="col">@lang('web.settings')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $key => $item)
                                            <tr>
                                                <th scope="row">{{++$key}}</th>
                                                <td>{{ json_decode($item, true)['title']['az'] }}</td>
                                                <td>{{ !empty($item->jobcategory->category)? json_decode($item->jobcategory->category, true)['name']['az']: '' }}</td>
                                                <td>{{ json_decode($item->city, true)['name']['az'] ?? null }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>
                                                    <span class="badge badge-soft-success">{{ json_decode($item->jobType, true)['name']['az'] }}</span>
                                                </td>
                                                <td>{{ date('d.m.Y',strtotime($item->created_at)) }}</td>
                                                <td>{{ date('d.m.Y',strtotime($item->updated_at)) }}</td>
                                                <td>
                                                    @if($item->status ==1)
                                                        <span class="badge bg-success">
                                                                @lang('web.active')
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                           @lang('web.not_active')
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" >
                                                            <a href="{{ route('web.user.jobs.edit',$item->id) }}" class="btn btn-sm btn-soft-info"><i
                                                                    class="mdi mdi-pencil-outline"></i></a>
                                                        </li>
                                                      {{--  <li data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                            <a href="#jobDelete" data-bs-toggle="modal"
                                                               class="btn btn-sm btn-soft-danger"><i
                                                                    class="mdi mdi-delete-outline"></i></a>
                                                        </li>--}}
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
    <div class="modal fade" id="jobDelete" tabindex="-1" aria-labelledby="jobDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body px-4 py-5 text-center">
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    <div class="avatar-sm mb-4 mx-auto">
                        <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </div>
                    </div>
                    <p class="text-muted font-size-16 mb-4">Are you sure you want to permanently erase the job.</p>

                    <div class="hstack gap-2 justify-content-center mb-0">
                        <button type="button" class="btn btn-danger">Delete Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('user.js')
@endsection
