@extends('admin.layouts.app')

@section('admin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    {{--    <link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}">--}}
@endsection
@section('admin.content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- end page title -->
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
                            <h4 class="card-title-desc">Blog Create</h4>
                            <form action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
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
                                                            <label for="input-{{$lang['code']}}" class="form-label">Title {{$lang['code']}}</label>
                                                            <input class="form-control" type="text" name="title[{{$lang['code']}}]" value=""  />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <div class="col-md-10">
                                                            <label for="input-{{$lang['code']}}" class="form-label">Description {{$lang['code']}}</label>
                                                            <textarea class="summernote-height form-control" type="text" name="description[{{$lang['code']}}]" ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="tab-pane" id="other" role="tabpanel">
                                        <div class="row">
                                            <div class="mb-3 row">
                                                <div class="col-md-5">
                                                    <label for="input-category" class="form-label">Kategory</label>
                                                    <select class="form-control" name="category_id" id="input-category">
                                                        <option value="">Sec</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}">{{ json_decode($category, true)['name']['az'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="input-category" class="form-label">Alt Kategory</label>
                                                    <select class="form-control" name="sub_category_id">
                                                        <option value="">Alt Kateqoriyanı seç</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-image" class="form-label">Image</label>
                                                    <input class="form-control" type="file" name="image" id="input-image">
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
    <script>
        $(document).ready(function() {

            $('#input-category').change(function() {

                var id = $(this).find(":selected").attr('value');
                $.ajax({
                    url: '{{ env('APP_URL ') }}/admin/category/sub-category/' + id,
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
