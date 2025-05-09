@extends('admin.layouts.app')

@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    {{--    <link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}">--}}
@endsection
@section('admin.content')
    <div class="page-content">
        <div class="container-fluid">

            @if ( Session::get('error'))
                <div class="col-12 mt-1">
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">{{ Session::get('error') }}</div>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title-desc">Job Create</h4>

                            <form action="{{ route('admin.jobs.update',$job->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    @if(!empty($locales))
                                        @foreach($locales as $key => $lang)
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link @if(++$key ==1) active @endif" data-bs-toggle="tab" href="#{{$lang->code}}" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">{{$lang->code}}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#other" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Other</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content p-3 text-muted">
                                    @if(!empty($locales))
                                        @foreach($locales as $key => $lang)
                                            <div class="tab-pane @if(++$key ==1) active @endif" id="{{$lang['code']}}" role="tabpanel">
                                                <div class="row">
                                                    <div class="mb-3 row">
                                                        <div class="col-md-10">
                                                            <label for="input-ru" class="form-label">Title {{$lang['code']}}</label>
                                                            <input class="form-control" type="text" name="title[{{$lang['code']}}]" value="{{ json_decode($job, true)['title'][$lang['code']] ?? null }}" id="input-az" />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <div class="col-md-10">
                                                            <label for="input-az" class="form-label">Description {{$lang['code']}}</label>
                                                            <textarea class="summernote-height form-control" type="text" name="description[{{$lang['code']}}]" id="input-az">{{ json_decode($job, true)['description'][$lang['code']] ?? null }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="tab-pane" id="other" role="tabpanel">
                                        <div class="row">
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-city" class="form-label">City</label>
                                                    <select class="form-control" name="city_id" id="input-city">
                                                        <option value="">Sec</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}" @if(!empty($job->city_id) && $job->city_id == $city->id) selected @endif>{{ json_decode($city, true)['name']['az'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-user" class="form-label">Users</label>
                                                    <select class="form-control" name="user_id" id="input-user">
                                                        <option value="">Sec</option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}" @if(!empty($job->user_id) && $job->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-company" class="form-label">Company</label>
                                                    <select class="form-control" name="company_id" id="input-company">
                                                        <option value="">Sec</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{$company->id}}" @if(!empty($job->company_id) && $job->company_id == $company->id) selected @endif>{{ json_decode($company, true)['name']['az'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-category" class="form-label">Kategory</label>
                                                    <select class="form-control" name="category_id" id="input-category">
                                                        <option value="">Sec</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" @if(!empty($job->jobcategory->category_id) && $job->jobcategory->category_id == $category->id) selected @endif>{{ json_decode($category, true)['name']['az'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-type" class="form-label">Type</label>
                                                    <select class="form-control" name="job_type_id" id="input-type">
                                                        <option value="">Sec</option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}" @if(!empty($job->job_type_id) && $job->job_type_id == $type->id) selected @endif>{{ json_decode($type, true)['name']['az'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if(isset($job->logo))
                                                <div class="mb-3 row">
                                                    <img src="{{ asset("uploads/jobs/".$job->logo) }}" style="max-width: 167px;"/>
                                                    <div class="col-md-10">
                                                        <label for="input-logo" class="form-label">Logo</label>
                                                        <input class="form-control" type="file" name="logo" id="input-logo" value="{{$job->logo}}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-price" class="form-label">Price</label>
                                                    <input class="form-control" type="text" name="price" value="{{$job->price}}" id="input-price">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                <div class="dash-input-wrapper mb-20">
                                                    <label for="created_at">Əlavə edilmə tarixi</label>
                                                    <input type="datetime-local" id="phone" placeholder="Əlavə edilmə tarixi" value="{{$job->created_at ?? ''}}" name="created_at"/>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                <div class="dash-input-wrapper mb-20">
                                                    <label for="updated_at">Bitmə tarixi</label>
                                                    <input type="datetime-local" id="updated_at" placeholder="Bitmə tarixi" value="{{$job->updated_at ?? ''}}"  name="updated_at"/>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row  mt-4">
                                        <div class="col-md-" dir="ltr">
                                            <button class="btn btn-success" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection

@section('admin.js')
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var errorDiv = document.getElementById('error-message');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }, 2000);
        });
    </script>
@endsection
