@extends('web.layouts.app')
@section('site.title')
    Əlaqə
@endsection
@section('web.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .center {
            position: absolute;
            top: 105%;
            left: 52%;
            transform: translate(-50%, -50%);
        }
        .captcha{
            width: 63%;
            height: 48px;
            padding: 20px;
            border: none;
            background-color: #f0f6fe;
            border-radius: 10px;
            font-size: medium;
        }
    </style>
@endsection
@section('web.section')
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ asset('site/images/banner/1.jpg') }});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">@lang('site.contact_us')</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('web.home') }}">@lang('site.home')</a></li>
                            <li>@lang('site.contact_us')</li>
                        </ul>
                    </div>
                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- CONTACT FORM -->
        <div class="section-full twm-contact-one">
            <div class="section-content">
                <div class="container">

                    <!-- CONTACT FORM-->
                    <div class="contact-one-inner">
                        <div class="row">

                            <div class="col-lg-6 col-md-12">
                                <div class="contact-form-outer">

                                    <!-- TITLE START-->
                                    <div class="section-head left wt-small-separator-outer">
                                        <h2 class="wt-title">@lang('site.contact_title')</h2>
                                        <p>@lang('site.contact_text')</p>
                                    </div>
                                    <!-- TITLE END-->

                                    <form  class="cons-contact-form" id="contactSend" action="{{ route('web.contactform') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="full_name" id="full_name" type="text" class="form-control" placeholder="@lang('site.full_name')">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="email" id="email" type="email" class="form-control" placeholder="@lang('site.email')">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="phone" id="phone" type="text" class="form-control" placeholder="@lang('site.phone')">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <select id="type" name="type" class="form-control" title="@lang('site.choose_type')">
                                                        <option value="">@lang('site.choose_type')</option>
                                                        <option value="company">@lang('site.company')</option>
                                                        <option value="users">@lang('site.user')</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">

                                                <div class="form-group mb-3">
                                                    <textarea name="messages" id="messages" class="form-control" rows="3" placeholder="@lang('site.messages')"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-check-label rem-forgot" for="Password4">
                                                        <input type="text"  class="captcha" name="captcha" id="captcha" placeholder="@lang('site.please_enter_captcha')">
                                                        <img src="{{ url('/captcha') }}" alt="CAPTCHA">
                                                    </label>
                                                </div>
                                                <button id="buttonContactSend" class="site-button">@lang('site.send')</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="contact-info-wrap">

                                    <div class="contact-info">
                                        <div class="contact-info-section">

                                            <div class="c-info-column">
                                                <div class="c-info-icon"><i class=" fas fa-map-marker-alt"></i></div>
                                                <h3 class="twm-title">@lang('site.address')</h3>
                                                <p>Azərbaycan/Bakı</p>
                                            </div>

                                            <div class="c-info-column">
                                                <div class="c-info-icon custome-size"><i class="fas fa-mobile-alt"></i></div>
                                                <h3 class="twm-title">@lang('site.phone')</h3>
                                                <p><a href="tel:+994997027093">+99499 702 7093</a></p>
                                            </div>

                                            <div class="c-info-column">
                                                <div class="c-info-icon"><i class="fas fa-envelope"></i></div>
                                                <h3 class="twm-title">@lang('site.email')</h3>
                                                <p><a href="mailto:isveren.consulting@gmail.com">isveren.consulting@gmail.com</a></p>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="gmap-outline">
            <div class="google-map">
                <div style="width: 100%">
                    <iframe height="460" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d194473.18588939894!2d49.8549596!3d40.394592499999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307d6bd6211cf9%3A0x343f6b5e7ae56c6b!2sBaku!5e0!3m2!1sen!2saz!4v1700761016091!5m2!1sen!2saz"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('web.js')
    <script>
        $(document).ready(function () {
            $('#contactSend').submit(function (e) {
                e.preventDefault();
                let formData = new FormData($('#contactSend')[0]);
                let submitButton = $('#buttonContactSend');
                let captchaField = $('#captcha');
                // Düyməni deaktiv et və "Yoxlanılır..." yaz
                submitButton.prop('disabled', true).text('@lang("site.verifying")...');
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        let modal = $('#messagesCon');
                        if (response.success == true) {
                            modal.find('.modal-message').html('<p style="color: #00aa18;font-weight: bold;">' + response.message + '</p>');
                            modal.find('.modal-message').removeClass('error').addClass('success fade-in');
                            modal.find('.modal-icon').html('<img src="' + '{{ asset("site/icon/check.png") }}' + '" style="max-width: 57px;" alt="Success" />');
                            submitButton.prop('disabled', false).text('@lang("site.close")');
                            // $(".settingForm")[0].reset();
                            modal.modal('show');
                        } else {
                            modal.find('.modal-message').empty();
                            $.each(response.errors, function (index, value) {
                                console.log(value);
                                modal.find('.modal-message').append('<p style="font-weight: bold;">' + value + '</p>');
                            });
                            modal.find('.modal-message').removeClass('success').addClass('error fade-in');
                            modal.find('.modal-icon').html('<img src="{{ asset("site/icon/close.png") }}" style="max-width: 57px;" alt="Error" />');
                            modal.modal('show');
                            captchaField.val('');
                            captchaField.siblings('img').attr('src', '{{ url("/captcha") }}?' + Math.random());
                        }
                        // Düyməni aktiv et və orijinal mətnini qaytar
                        submitButton.prop('disabled', false).text('@lang("site.close")');
                    },error: function (errors) {
                        console.log(errors);

                        let modal = $('#messagesCon');
                        let errorMessage = '';

                        if (errors.responseJSON && errors.responseJSON.errors) {
                            // Laravel doğrulama səhvləri varsa
                            errorMessage = '<ul>';
                            $.each(errors.responseJSON.errors, function (key, messages) {
                                errorMessage += '<li>' + messages[0] + '</li>'; // Birinci səhv mesajını göstər
                            });
                            errorMessage += '</ul>';
                        } else if (errors.responseJSON && errors.responseJSON.message) {
                            // Başqa bir JSON formatında mesaj gəlirsə
                            errorMessage = '<p>' + errors.responseJSON.message + '</p>';
                        } else {
                            // Əgər JSON deyilsə, sadəcə string kimi göstər
                            errorMessage = '<p>' + errors.statusText + '</p>';
                        }

                        modal.find('.modal-icon').html('<img src="' + '{{ asset("site/icon/close.png") }}' + '" style="max-width: 57px;" alt="Error" />');
                        modal.find('.modal-message').html('<div class="btn-danger" style="text-align: center;">' + errorMessage + '</div>');
                        modal.find('.modal-message').removeClass('success').addClass('error fade-in');
                        modal.modal('show');

                        // Düyməni aktiv et və orijinal mətnini qaytar
                        submitButton.prop('disabled', false).text('@lang("site.close")');
                        captchaField.val('');
                        captchaField.siblings('img').attr('src', '{{ url("/captcha") }}?' + Math.random());
                    }

                });
            });
        });
    </script>
@endsection
