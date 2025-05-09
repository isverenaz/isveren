@extends('web.users.user-menu')
@section('user.css')
    <style>
        .button{
            text-align: center;
            display: ruby-text;
        }
    </style>
    <style>
        input:invalid {
            border: 2px solid red;
        }
        select:invalid {
            border: 2px solid red;
        }
        textarea:invalid {
            border: 2px solid red;
        }
    </style>
@endsection
@section('user.section')
    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
        <!--Filter Short By-->
        <div class="twm-right-section-panel site-bg-gray">
                <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-body wt-panel-body p-a20 m-b30 ">
                    <form  id="settings" action="{{ route('web.user.settings_update',$user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.name')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" name="name" id="name" type="text" value="{{ $user->name }}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        <i class="fs-input-icon fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.surname')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" name="surname" id="surname" type="text" value="{{ $user->surname }}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        <i class="fs-input-icon fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.position')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" name="position" id="position" type="text" value="{{ $user->position }}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        <i class="fs-input-icon fa fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.phone')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" name="phone" type="text" id="phone" placeholder="+99499 702 70 93" value="{{ $user->phone }}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        <i class="fs-input-icon fa fa-phone-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.email')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" name="email" type="email" id="email" placeholder="isveren.consulting@gmail.com" value="{{ $user->email }}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        <i class="fs-input-icon fas fa-at"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6  col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.current_password')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control wt-form-control" name="current_password" id="current_password" type="password" placeholder="*****">
                                        <i class="fs-input-icon fa fa-asterisk"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.new_password')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control wt-form-control" name="password" id="password" type="password" placeholder="*****">
                                        <i class="fs-input-icon fa fa-asterisk"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-md-12">
                                <div class="form-group">
                                    <label>@lang('site.new_re_password')</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control wt-form-control" name="re_password" id="re_password" type="password" placeholder="*****">
                                        <i class="fs-input-icon fa fa-asterisk"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="text-left">
                                    <button id="submit" class="site-button">@lang('site.save')</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('user.js')
    <!-- JAVASCRIPT  FILES ========================================= -->
    <script>
        $(document).ready(function() {
            $('#settings').submit(function(e) {
                e.preventDefault();
                let submitButton = $('#submit');
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
@endsection
