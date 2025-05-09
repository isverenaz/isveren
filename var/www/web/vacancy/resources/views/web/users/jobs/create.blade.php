@extends('web.users.user-menu')
@section('user.css')
    <link href="{{ asset('web/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- dropzone css -->
    <link href="{{ asset('web/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
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
                        <h4 class="mb-sm-0 font-size-18">@lang('web.jobs_add')</h4>
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
                            <form action="{{ route('web.user.jobs.store') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <input id="title" name="title[az]" type="text" class="form-control"
                                               placeholder="@lang('web.title')">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <textarea class="summernote-height form-control" name="description[az]" rows="3"
                                                  placeholder="@lang('web.description')"></textarea>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <div class="input-daterange input-group">
                                            <input type="number" class="form-control"
                                                   placeholder="@lang('web.min_salary')" name="min_salary"/>
                                            <input type="number" class="form-control" style="margin-left: 5px"
                                                   placeholder="@lang('web.max_salary')" name="max_salary"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <div class="input-daterange input-group">
                                            <select class="form-control" name="category_id" id="input-category">
                                                <option value="">Əsas kateqoriyanı seç</option>

                                                @if (!empty($categories))
                                                    @foreach ($categories as $key => $cat)
                                                        @if ($cat->parent_id == null)
                                                            <option value="{{ $cat->id }}"> {!! json_decode($cat, true)['name']['az'] !!}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>


                                            <select class="form-control" name="sub_category_id">
                                                <option value="">Kateqoriyanı seç</option>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <div class="input-daterange input-group">
                                            <select class="form-control" name="city_id" id="input-city">
                                                <option value="">@lang('web.city_choose')</option>
                                                @foreach($cities as $city)
                                                    <option
                                                        value="{{$city->id}}">{{ json_decode($city, true)['name']['az'] }}</option>
                                                @endforeach
                                            </select>

                                            <select class="form-control" name="job_type_id" id="input-type" style="margin-left: 5px">
                                                <option value="">@lang('web.type_choose')</option>
                                                @foreach($types as $type)
                                                    <option
                                                        value="{{$type->id}}">{{ json_decode($type, true)['name']['az'] }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-lg-7">
                                        <div class="input-daterange input-group">
                                            <select class="form-control" name="company_id" id="input-company">
                                                <option value="">@lang('web.company_choose')</option>
                                                @foreach($companies as $company)
                                                    <option
                                                        value="{{$company->id}}">{{ json_decode($company, true)['name']['az'] }}</option>
                                                @endforeach
                                            </select>

                                            <a href="" style="padding-left: 35px; padding-top: 6px; font-size: 15px; color: #061e40 ">Əlavə et</a>

                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="form-control" placeholder="@lang('web.email')"
                                                   name="email"/>
                                            <input type="text" class="form-control" style="margin-left: 5px" placeholder="@lang('web.phone')"
                                                   name="phone"/>

                                        </div>
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
    <script>
        $(document).ready(function() {

            $('#input-category').change(function() {

                var id = $(this).find(":selected").attr('value');
                $.ajax({
                    url: 'https://isveren.az/user/sub-category/' + id,
                    type: 'GET',
                    dataType: 'json',

                }).done(function(data) {

                    var select = $('select[name=sub_category_id]');
                    select.empty();
                    $.each(data, function(key, value) {
                        select.append('<option value=' + value.id + '>' +
                            decodeURIComponent(value.name['az']) + '</option>');
                    });
                })
            });
        });
    </script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('web/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- dropzone plugin -->
    <script src="{{ asset('web/assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
@endsection
