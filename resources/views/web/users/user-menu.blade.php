@extends('web.layouts.app')
@section('site.title')
    Hesabım
@endsection
@section('web.css')
    @yield('user.css')
@endsection
@section('web.section')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ asset("site/images/banner/1.jpg") }});">{{--site/img/r.jpg--}}
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Hesabınıza xoş gəlmisiniz!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- OUR BLOG START -->
        <div class="section-full p-t120  p-b90 site-bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-12 rightSidebar m-b30">
                        <div class="side-bar-st-1">
                            <div class="twm-candidate-profile-pic">
                                @if(empty(auth()->guard('web')->user()->image))
                                    <img src="{{ asset("site\img\user.png") }}" alt="">
                                @else
                                    <img src="{{ asset("uploads/user/userlogo/".auth()->guard('web')->user()->image) }}" alt="">
                                @endif
                                <form id="settinglogo" action="{{ route('web.user.settings_update',auth()->guard('web')->user()->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="upload-btn-wrapper">
                                        <div id="upload-image-grid"></div>
                                        <button type="button" class="site-button button-sm">Yenilə</button>
                                        <input type="file" name="userlogo" id="userlogo" accept=".jpg, .jpeg, .png">
                                    </div>
                                </form>
                            </div>
                            <div class="twm-mid-content text-center">
                                <a href="{{ route('web.user.settings')  }}" class="twm-job-title">
                                    <h4>{{ auth()->guard('web')->user()->name }} {{ auth()->guard('web')->user()->surname ?? null }} </h4>
                                </a>
                                <p>{{ auth()->guard('web')->user()->position ?? null }}</p>
                            </div>
                            <div class="twm-nav-list-1">
                                <ul>
                                    <li class="{{ Route::currentRouteName() === 'web.user.dashboard' ? 'active' : '' }}"><a href="{{ route('web.user.dashboard') }}"><i class="fa fa-tachometer-alt"></i> Hesabım</a></li>
                                    <li class="{{ Route::currentRouteName() === 'web.user.settings' ? 'active' : '' }}"><a href="{{ route('web.user.settings') }}"><i class="fa fa-user"></i> Ayarlar</a></li>
                                    @if(!empty(auth()->guard('web')->user()->userRole->role) && in_array(auth()->guard('web')->user()->userRole->role->slug,['company','admin']))
                                        <li class="{{ Route::currentRouteName() === 'web.user.jobs.list' ? 'active' : '' }}"><a href="{{ route('web.user.jobs.list') }}"><i class="fa fa-suitcase"></i> İş elanlarım</a></li>
                                        <li class="{{ Route::currentRouteName() === 'web.user.company.list' ? 'active' : '' }}"><a href="{{ route('web.user.company.list') }}"><i class="fa fa-suitcase"></i> Şirkətlərim</a></li>
                                        <li class="{{ Route::currentRouteName() === 'web.company.appeal' ? 'active' : '' }}"><a href="{{ route('web.company.appeal') }}"><i class="fa fa-paperclip"></i> Müraciətlər</a></li>
                                    @endif
                                    @if(!empty(auth()->guard('web')->user()->userRole->role) && in_array(auth()->guard('web')->user()->userRole->role->slug,['users','admin']))
                                        <li class="{{ Route::currentRouteName() === 'web.user.cv' ? 'active' : '' }}"><a href="{{ route('web.user.cv') }}"><i class="fa fa-receipt"></i> CV İdarəsi</a></li>
{{--                                        <li class="{{ Route::currentRouteName() === 'web.user.follower' ? 'active' : '' }}"><a href="{{ route('web.user.follower') }}"><i class="fa fa-file-download"></i> Seçilmiş vakansiyalar</a></li>--}}
                                        <li class="{{ Route::currentRouteName() === 'web.user.appeal' ? 'active' : '' }}"><a href="{{ route('web.user.appeal') }}"><i class="fa fa-paperclip"></i> Müraciətlərim</a></li>
                                    @endif
                                    <li><a href="{{ route('web.user.logout') }}"><i class="fa fa-share-square"></i>Çıxış</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @yield('user.section')
                </div>
            </div>
        </div>
        <!-- OUR BLOG END -->
    </div>

    <div class="modal fade twm-saved-jobs-view" id="messages" aria-hidden="true" aria-labelledby="sign_up_popupLabel-3" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-icon" style="text-align: center;"></div>
                </div>
                <div class="modal-body">
                    <div class="modal-message" style="text-align: center;"></div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="outline-primary" data-bs-dismiss="modal">Bağla</a>
                    {{--                    <a href="{{ url()->current() }}" class="outline-primary">Bağla</a>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT END -->
@endsection
@section('web.js')
    <script>
        $(document).ready(function() {
            $('#userlogo').on('change', function() {
                let formData = new FormData($('#settinglogo')[0]);
                let submitButton = $('.site-button'); // Alternativ olaraq submit düyməsini tapaq

                // Düyməni deaktiv et və mətnini dəyiş
                submitButton.prop('disabled', true).text('@lang("site.verifying")...');

                $.ajax({
                    type: 'POST',
                    url: $('#settinglogo').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            showModalMessage('success', response.message);
                            // 2 saniyə sonra səhifəni yenilə
                            setTimeout(function () {
                                location.reload();
                            }, 100);
                        } else {
                            showModalMessage('error', response.errors || response.message);
                            submitButton.prop('disabled', false).text('@lang("site.save")');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            showModalMessage('error', xhr.responseJSON.errors);
                        } else {
                            showModalMessage('error', 'Xəta baş verdi.');
                        }
                        submitButton.prop('disabled', false).text('@lang("site.save")');
                    }
                });
            });
        });
        function showModalMessage(type, messages) {
            let modal = $('#messages');
            let iconUrl = type === 'success'
                ? '{{ asset("site/icon/check.png") }}'
                : '{{ asset("site/icon/close.png") }}';

            let messageHtml = '';

            // Əgər message obyekt şəklindədirsə (validation errors)
            if (typeof messages === 'object') {
                Object.values(messages).forEach(function (msgArray) {
                    msgArray.forEach(function (msg) {
                        messageHtml += `<p style="margin:0 0 5px;color:#e00;font-weight:bold;">${msg}</p>`;
                    });
                });
            } else {
                // Əgər sadə string mesajdırsa
                messageHtml = `<p style="margin:0;color:${type === 'success' ? '#00aa18' : '#e00'};font-weight:bold;">${messages}</p>`;
            }

            modal.find('.modal-message')
                .removeClass('success error fade-in')
                .addClass(type + ' fade-in')
                .html(messageHtml);

            modal.find('.modal-icon')
                .html(`<img src="${iconUrl}" style="max-width: 57px;" alt="${type}" />`);

            modal.modal('show');
        }
    </script>
    @yield('user.js')
@endsection





