@extends('web.users.user-menu')
@section('user.css')
    <link href="{{ asset('web/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- dropzone css -->
    <link href="{{ asset('web/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    {{--    <link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}">--}}

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//select2.github.io/select2/select2-3.4.1/select2.js"></script>
    <link rel="stylesheet" type="text/css" href="//select2.github.io/select2/select2-3.4.1/select2.css" />
@endsection
@section('user.section')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">@lang('web.job_edit')</h4>
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
                            <form action="{{ route('web.user.jobs.update',$job->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <input id="title" name="title[az]" type="text" class="form-control" placeholder="@lang('web.title')" value="{{ json_decode($job, true)['title']['az'] }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <textarea class="summernote-height form-control" name="description[az]" rows="3" placeholder="@lang('web.description')">{{ json_decode($job, true)['description']['az'] }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <?php
                                        $input_string = $job->price;
                                        $salary= explode('-', $input_string);
                                        ?>
                                        <div class="input-daterange input-group" >
                                            <input type="number" class="form-control" value="{{isset($salary[0])? $salary[0]: ''}}" placeholder="@lang('web.min_salary')" name="min_salary" />
                                            <input type="number" class="form-control" value="{{isset($salary[1])? $salary[1]: ''}}" placeholder="@lang('web.max_salary')" name="max_salary" />
                                        </div>
                                    </div>
                                </div>
                           
                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <div class="input-daterange input-group">
                                            <select class="form-control" name="category_id" id="input-category">
                                                <option value="">@lang('web.category_choose')</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" @if($category->id == (!empty($job->jobcategory->category_id)?$job->jobcategory->category_id: '')) selected @endif>{{ json_decode($category, true)['name']['az'] }}</option>
                                                @endforeach
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
                                        <div class="input-daterange input-group" >
                                            <select class="form-control select2" name="city_id" id="input-city">
                                                <option value="">@lang('web.city_choose')</option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" @if($city->id == $job->city_id) selected @endif>{{ json_decode($city, true)['name']['az'] }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control select2" name="company_id" id="input-company">
                                                <option value="">@lang('web.company_choose')</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" @if($company->id == $job->company_id) selected @endif>{{ json_decode($company, true)['name']['az'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <div class="input-daterange input-group" >
                                            <select class="form-control select2" name="job_type_id" id="input-type">
                                                <option value="">@lang('web.type_choose')</option>
                                                @foreach($types as $type)
                                                    <option value="{{$type->id}}" @if($type->id == $job->job_type_id) selected @endif>{{ json_decode($type, true)['name']['az'] }}</option>
                                                @endforeach
                                            </select>
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
                    url: '/user/sub-category/' + id + '',
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
