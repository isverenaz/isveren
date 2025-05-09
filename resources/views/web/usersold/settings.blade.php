@extends('web.users.user-menu')
@section('user.css')
    <link href="{{ asset('user/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('user/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('user.section')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">@lang('web.settings')</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('web.user.settings_update',$user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <img src="@if(isset($user->image)) {{asset('uploads/user/image/'.$user->image) }} @else {{ asset('user/user.png') }} @endif" style="max-width: 11%;border-radius: 50%;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="name">@lang('web.name')</label>
                                            <input id="name" name="name" type="text" class="form-control" placeholder="@lang('web.name')" value="{{ $user->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="parent">@lang('web.parent')</label>
                                            <input id="parent" name="parent" type="text" class="form-control" placeholder="@lang('web.parent')" value="{{ $user->parent }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">@lang('web.email')</label>
                                            <input id="email" name="email" type="email" class="form-control" placeholder="@lang('web.email')" value="{{ $user->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password">@lang('web.new_password')</label>
                                            <input id="new_password" name="new_password" type="password" class="form-control" placeholder="*****">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="image">@lang('web.image')</label>
                                            <input id="image" name="image" type="file" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="surname">@lang('web.surname')</label>
                                            <input id="surname" name="surname" type="text" class="form-control" placeholder="@lang('web.surname')" value="{{ $user->surname }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">@lang('web.phone')</label>
                                            <input id="phone" name="phone" type="text" class="form-control" placeholder="@lang('web.phone')" value="{{ $user->phone }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="password">@lang('web.password')</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="*****">
                                        </div>
                                        <div class="mb-3">
                                            <label for="re_password">@lang('web.re_password')</label>
                                            <input id="re_password" name="re_password" type="password" class="form-control" placeholder="*****">
                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('web.save')</button>
                                    <button type="button" class="btn btn-secondary waves-effect waves-light">@lang('web.cancel')</button>
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
    <script src="{{ asset('user/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('user/assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/pages/ecommerce-select2.init.js') }}"></script>
@endsection
