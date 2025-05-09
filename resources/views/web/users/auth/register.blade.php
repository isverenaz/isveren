<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <meta name="robots" content=""/>
    <meta name="description" content=""/>
    <!-- FAVICONS ICON -->
    <link rel="icon" href="{{ asset("site/logo/favicon.png") }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("site/logo/favicon.png") }}"/>
    <!-- PAGE TITLE HERE -->
    <title>iş Verən- @lang('site.register')</title>
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/bootstrap.min.css") }}"><!-- BOOTSTRAP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/font-awesome.min.css") }}"><!-- FONTAWESOME STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/feather.css") }}"><!-- FEATHER ICON SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/owl.carousel.min.css") }}"><!-- OWL CAROUSEL STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/magnific-popup.min.css") }}"><!-- MAGNIFIC POPUP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/lc_lightbox.css") }}"><!-- Lc light box popup -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/bootstrap-select.min.css") }}"><!-- BOOTSTRAP SLECT BOX STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/dataTables.bootstrap5.min.css") }}"><!-- DATA table STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/select.bootstrap5.min.css") }}">
    <!-- DASHBOARD select bootstrap  STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/dropzone.css") }}"><!-- DROPZONE STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/scrollbar.css") }}"><!-- CUSTOM SCROLL BAR STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/datepicker.css") }}"><!-- DATEPICKER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/flaticon.css") }}"> <!-- Flaticon -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/swiper-bundle.min.css") }}"><!-- Swiper Slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/style.css") }}"><!-- MAIN STYLE SHEET -->
    <!-- THEME COLOR CHANGE STYLE SHEET -->
    <link rel="stylesheet" class="skin" type="text/css" href="{{ asset("site/css/skins-type/skin-6.css") }}">
    <!-- SIDE SWITCHER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/switcher.css") }}">
    <style>
        @media (max-width: 768px) {
            .twm-log-reg-media-wrap {
                display: none;
            }
        }
        .buttonRegister{
            text-align: center;
            display: ruby-text;
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
</head>
<body style="font-size: 32px;!important;">
<!-- LOADING AREA START ===== -->
<div class="loading-area">
    <div class="loading-box"></div>
    <div class="loading-pic">
        <div class="wrapper">
            <div class="cssload-loader"></div>
        </div>
    </div>
</div>
<!-- LOADING AREA  END ====== -->
<div class="page-wraper">
    <!-- CONTENT START -->
    <div class="page-content">
        <!-- register Section Start -->
        <div class="section-full site-bg-white">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-2 col-md-3 twm-log-reg-media-wrap" style="background-image: url('{{ asset("site/img/d.png") }}'); background-size: cover;background-position: center;">
                        <div class="twm-log-reg-media">
                            <div class="twm-l-media">
{{--                                <a href="https://sizinlink.com" class="btn btn-primary">Hesab var</a>--}}

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8 col-md-9">
                        <div class="twm-log-reg-form-wrap">
                            <div class="twm-log-reg-logo-head">
                                <a href="{{ route('web.home') }}">
                                    <img src="{{ asset("site/logo/logo.png") }}" alt="" class="logo">
                                </a>
                            </div>
                            <div class="twm-log-reg-inner">
                                <div class="twm-tabs-style-2">
                                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                        <!--register Candidate-->
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#twm-register-candidate" type="button"><i class="fas fa-user-tie"></i>@lang('site.user')</button>
                                        </li>
                                        <!--register Employer-->
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#twm-register-Employer" type="button"><i class="fas fa-building"></i>@lang('site.company')</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab2Content">
                                        <!--register Candidate Content-->
                                        <div class="tab-pane fade show active" id="twm-register-candidate">
                                            <div class="row">
                                                <form id="userRegister" action="{{ route('web.userRegisterAccept') }}" method="POST">
                                                    @csrf
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input name="name_surname" type="text" id="name_surname" class="form-control" placeholder="@lang('site.please_enter_your_name_surname')">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input name="phone" type="text" id="phone" class="form-control" placeholder="@lang('site.please_enter_your_phone')*">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input type="email" name="email" class="form-control" id="email" placeholder="@lang('site.please_enter_your_email')*">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input type="password" name="password" class="form-control" id="password" placeholder="@lang('site.please_enter_your_password')*">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="twm-forgot-wrap">
                                                            <div class="form-group">
                                                                <label class="form-check-label rem-forgot" for="Password4">
                                                                    <input type="text" class="captcha" name="captcha" id="captcha" placeholder="@lang('site.please_enter_captcha')">
                                                                    <img src="{{ url('/captcha') }}" alt="CAPTCHA">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 buttonRegister">
                                                        <div class="form-group">
                                                            <button id="submit" class="site-button">@lang('site.register')</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <span class="center-text-or">@lang('site.or')</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <a href="{{ route('web.login') }}" class="log_with_facebook">
                                                            <i class="feather-log-in"></i>
                                                            @lang('site.account_has')
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <a  href="{{ url('auth/user-google') }}" class="log_with_google">
                                                            <img src="{{ asset("site/icon/google-icon.png") }}" alt="">
                                                            @lang('site.enter_with_google')
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Register Employer Content-->
                                        <div class="tab-pane fade" id="twm-register-Employer">
                                            <div class="row">
                                                <form id="companyRegister" action="{{ route('web.companyRegisterAccept') }}" method="POST">
                                                    @csrf
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input name="name_surname" type="text" id="name_surname" class="form-control" placeholder="@lang('site.please_enter_your_name_surname')">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input name="phone" type="text" id="phone" class="form-control" placeholder="@lang('site.please_enter_your_phone')*">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input type="email" name="email" class="form-control" id="email" placeholder="@lang('site.please_enter_your_email')*">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <input type="password" name="password" class="form-control" id="password" placeholder="@lang('site.please_enter_your_password')*">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="twm-forgot-wrap">
                                                            <div class="form-group">
                                                                <label class="form-check-label rem-forgot" for="Password4">
                                                                    <input type="text" class="captcha" name="companyCaptcha" id="companyCaptcha" placeholder="@lang('site.please_enter_captcha')">
                                                                    <img src="{{ url('/captcha') }}" alt="CAPTCHA">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 buttonRegister">
                                                        <div class="form-group">
                                                            <button id="submit" class="site-button">@lang('site.register')</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <span class="center-text-or">@lang('site.or')</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <a href="{{ route('web.login') }}" class="log_with_facebook">
                                                            <i class="feather-log-in"></i>
                                                            @lang('site.account_has')
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <a  href="{{ url('auth/company-google') }}" class="log_with_google">
                                                            <img src="{{ asset("site/icon/google-icon.png") }}" alt="">
                                                            @lang('site.enter_with_google')
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-2 col-md-3 twm-log-reg-media-wrap" style="background-image: url('{{ asset("site/img/d.png") }}'); background-size: cover;background-position: center;">
                        <div class="twm-log-reg-media">
                            <div class="twm-l-media">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Section End -->
    </div>
    <!-- CONTENT END -->
    <!-- BUTTON TOP START -->
    <button class="scroltop"><span class="fa fa-angle-up  relative" id="btn-vibrate"></span></button>
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
                    <button type="button" class="site-button outline-primary" data-bs-dismiss="modal">Bağla</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JAVASCRIPT  FILES ========================================= -->
<script src="{{ asset("site/js/jquery-3.6.0.min.js") }}"></script><!-- JQUERY.MIN JS -->
<script src="{{ asset("site/js/popper.min.js") }}"></script><!-- POPPER.MIN JS -->
<script src="{{ asset("site/js/bootstrap.min.js") }}"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ asset("site/js/magnific-popup.min.js") }}"></script><!-- MAGNIFIC-POPUP JS -->
<script src="{{ asset("site/js/waypoints.min.js") }}"></script><!-- WAYPOINTS JS -->
<script src="{{ asset("site/js/counterup.min.js") }}"></script><!-- COUNTERUP JS -->
<script src="{{ asset("site/js/waypoints-sticky.min.js") }}"></script><!-- STICKY HEADER -->
<script src="{{ asset("site/js/isotope.pkgd.min.js") }}"></script><!-- MASONRY  -->
<script src="{{ asset("site/js/imagesloaded.pkgd.min.js") }}"></script><!-- MASONRY  -->
<script src="{{ asset("site/js/owl.carousel.min.js") }}"></script><!-- OWL  SLIDER  -->
<script src="{{ asset("site/js/theia-sticky-sidebar.js") }}"></script><!-- STICKY SIDEBAR  -->
<script src="{{ asset("site/js/lc_lightbox.lite.js") }}"></script><!-- IMAGE POPUP -->
<script src="{{ asset("site/js/bootstrap-select.min.js") }}"></script><!-- Form js -->
<script src="{{ asset("site/js/dropzone.js") }}"></script><!-- IMAGE UPLOAD  -->
<script src="{{ asset("site/js/jquery.scrollbar.js") }}"></script><!-- scroller -->
<script src="{{ asset("site/js/bootstrap-datepicker.js") }}"></script><!-- scroller -->
<script src="{{ asset("site/js/jquery.dataTables.min.js") }}"></script><!-- Datatable -->
<script src="{{ asset("site/js/dataTables.bootstrap5.min.js") }}"></script><!-- Datatable -->
<script src="{{ asset("site/js/chart.js") }}"></script><!-- Chart -->
<script src="{{ asset("site/js/bootstrap-slider.min.js") }}"></script><!-- Price range slider -->
<script src="{{ asset("site/js/swiper-bundle.min.js") }}"></script><!-- Swiper JS -->
<script src="{{ asset("site/js/custom.js") }}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{ asset("site/js/switcher.js") }}"></script><!-- SHORTCODE FUCTIONS  -->
{{--//start user--}}
<script>
    $(document).ready(function() {
        $('#userRegister').submit(function(e) {
            e.preventDefault();
            let submitButton = $('#submit');
            let captchaField = $('#captcha');

            // Düyməni deaktiv et və "Yoxlanılır..." yaz
            submitButton.prop('disabled', true).text('@lang("site.verifying")...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showModalMessage('success', response.message);
                        // 2 saniyə sonra səhifəni yenilə
                        window.location = response.redirect;
                    } else {
                        showModalMessage('error', response.errors || response.message);
                        submitButton.prop('disabled', false).text('@lang("site.save")');
                        captchaField.val('');
                        captchaField.siblings('img').attr('src', '{{ url("/captcha") }}?' + Math.random());
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        showModalMessage('error', xhr.responseJSON.errors);
                    } else {
                        showModalMessage('error', 'Xəta baş verdi.');
                    }
                    captchaField.val('');
                    captchaField.siblings('img').attr('src', '{{ url("/captcha") }}?' + Math.random());
                    submitButton.prop('disabled', false).text('@lang("site.save")');
                }
            });
        });
    });
{{--</script>
--}}{{--//end user--}}{{--
--}}{{--//start company--}}{{--
<script>--}}
    $(document).ready(function() {
        $('#companyRegister').submit(function(e) {
            e.preventDefault();
            let submitButton = $('#submit');
            let captchaField = $('#companyCaptcha');

            // Düyməni deaktiv et və "Yoxlanılır..." yaz
            submitButton.prop('disabled', true).text('@lang("site.verifying")...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showModalMessage('success', response.message);
                        // 2 saniyə sonra səhifəni yenilə
                        window.location = response.redirect;
                    } else {
                        showModalMessage('error', response.errors || response.message);
                        submitButton.prop('disabled', false).text('@lang("site.save")');
                        captchaField.val('');
                        captchaField.siblings('img').attr('src', '{{ url("/captcha") }}?' + Math.random());
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        showModalMessage('error', xhr.responseJSON.errors);
                    } else {
                        showModalMessage('error', 'Xəta baş verdi.');
                    }
                    submitButton.prop('disabled', false).text('@lang("site.save")');
                    captchaField.val('');
                    captchaField.siblings('img').attr('src', '{{ url("/captcha") }}?' + Math.random());
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
{{--//end company--}}
</body>
</html>