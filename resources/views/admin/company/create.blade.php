@extends('admin.layouts.app')

@section('admin.css')

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
                            <h4 class="card-title-desc">Company Create</h4>

                            <form action="{{ route('admin.company.store') }}" method="post" enctype="multipart/form-data">
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
                                                            <label for="input-{{$lang['code']}}" class="form-label">Name {{$lang['code']}}</label>
                                                            <input class="form-control" type="text" name="name[{{$lang['code']}}]" value="" id="input-{{$lang['code']}}" />
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-md-10">
                                                            <label for="input-{{$lang['code']}}" class="form-label">Address {{$lang['code']}}</label>
                                                            <input class="form-control" type="text" name="address[{{$lang['code']}}]" value="" id="input-{{$lang['code']}}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-md-10">
                                                            <label for="input-{{$lang['code']}}" class="form-label">Description az</label>
                                                            <textarea class="form-control" type="text" name="description[{{$lang['code']}}]" id="input-{{$lang['code']}}"></textarea>
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
                                                    <label for="input-logo" class="form-label">Logo</label>
                                                    <input class="form-control" type="file" name="logo" id="input-logo">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-10">
                                                    <label for="input-contract" class="form-label">Contract</label>
                                                    <input class="form-control" type="file" name="contract" id="input-contract">
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
