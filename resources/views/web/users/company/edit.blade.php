@extends('web.users.user-menu')
@section('user.css')
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
            <form id="companySave" action="{{ route('web.user.company.update',$company['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!--Job title-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Şirkət adı</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control"name="name[az]" type="text" placeholder="İş Verən Consulting" value="{!! $company['name']['az'] !!}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon fa fa-address-card"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Şirkət ünvanı</label>
                            <div class="ls-inputicon-box">
                                <div class="ls-inputicon-box">
                                    <input class="form-control" name="address[az]" type="text" placeholder="Azərbaycan/Bakı" value="{!! $company['address']['az'] !!}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                    <i class="fs-input-icon fa fa-map-marker-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Şirkət logo</label>
                            <div class="ls-inputicon-box">
                                <div class="ls-inputicon-box">
                                    <input class="form-control" name="logo" type="file" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Description-->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Şirkət haqqında daha ətraflı məlumat</label>
                            <textarea class="form-control" rows="3" name="description[az]" placeholder="..." required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">{!! $company['description']['az'] !!}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="text-left">
                            <button type="buttonCompanySave" class="site-button m-r5">Yadda saxla</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('user.js')
    <script>
        $(document).ready(function () {
            $('#companySave').submit(function (e) {
                e.preventDefault();
                let formData = new FormData($('#companySave')[0]);
                let submitButton = $('#buttonCompanySave');
                // Düyməni deaktiv et və "Yoxlanılır..." yaz
                submitButton.prop('disabled', true).text('@lang("site.verifying")...');
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
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
@endsection
