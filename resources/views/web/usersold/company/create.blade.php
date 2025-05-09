@extends('web.users.user-menu')
@section('user.css')
    <link href="{{ asset('web/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- dropzone css -->
    <link href="{{ asset('web/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
{{--    <link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}">--}}
@endsection
@section('user.section')
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">@lang('web.add')</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
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
                            <div class="card-body">
                                <form action="{{ route('web.user.company.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{auth()->guard('web')->user()->id}}">
                                    <div class="row mb-4">
                                        <div class="col-lg-14">
                                            <input id="title" name="name[az]" type="text" class="form-control" placeholder="@lang('web.name')">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-14">
                                            <input id="address" name="address[az]" type="text" class="form-control" placeholder="@lang('web.address')">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-14">
                                            <textarea class="form-control" name="description[az]" rows="3" placeholder="@lang('web.description')"></textarea>
                                        </div>
                                    </div>

                                <div class="row justify-content-end">
                                    <div class="col-lg-1">
                                        <button type="submit" class="btn btn-primary">@lang('web.save')</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('user.js')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('web/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- dropzone plugin -->
    <script src="{{ asset('web/assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
@endsection
