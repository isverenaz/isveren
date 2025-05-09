@extends('web.users.user-menu')
@section('user.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Bootstrap və jQuery əlavə edin -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
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
            <form id="jobSave" action="{{ route('web.user.jobs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!--Job title-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Başlıq</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control" name="title[az]" type="text" placeholder="Proqramçı, Menecer və s." required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon fa fa-address-card"></i>
                            </div>
                        </div>
                    </div>

                    <!--Job Category-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group city-outer-bx has-feedback">
                            <label>Əsas kateqorya</label>
                            <div class="ls-inputicon-box">
                                <select class="wt-select-box selectpicker"  data-live-search="true" title="" id="j-category" data-bv-field="size" name="category_id" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" onchange="this.setCustomValidity('')">
                                    <option >Əsas kateqorya seç</option>
                                    @if(!empty($categories[0]))
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}">{{$category['name']['az']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fs-input-icon fa fa-border-all"></i>
                            </div>
                        </div>
                    </div>
                    <!--Job Category-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group city-outer-bx has-feedback">
                            <label>Kateqorya</label>
                            <div class="ls-inputicon-box">
                                <select class="wt-select-box selectpicker"  data-live-search="true" id="j-sub-category" data-bv-field="size" name="sub_category_id" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                    <option value="">Kateqorya seç</option>
                                </select>
                                <i class="fs-input-icon fa fa-border-all"></i>
                            </div>
                        </div>
                    </div>

                    <!--Job Type-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>İş rejimi</label>
                            <div class="ls-inputicon-box">
                                <select class="wt-select-box selectpicker"  data-live-search="true" title="" id="s-job-type" data-bv-field="size" name="job_type_id" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                    <option class="bs-title-option" value="">İş rejimi seçin</option>
                                    @if(!empty($types[0]))
                                        @foreach($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']['az']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fs-input-icon fa fa-file-alt"></i>
                            </div>
                        </div>
                    </div>

                    <!--City-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Şəhər</label>
                            <div class="ls-inputicon-box">
                                <select class="wt-select-box selectpicker"  data-live-search="true" title="" id="s-city" name="city_id" data-bv-field="size" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                    <option class="bs-title-option" value="">Şəhəri seçin</option>
                                    @if(!empty($cities[0]))
                                        @foreach($cities as $city)
                                            <option value="{{$city['id']}}">{{$city['name']['az']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fs-input-icon fa fa-globe-americas"></i>
                            </div>
                        </div>
                    </div>
                    <!--Company-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Şirkət</label>
                            <div class="ls-inputicon-box">
                                <select class="wt-select-box selectpicker"  data-live-search="true" title="" id="company" name="company_id" data-bv-field="size" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                    <option class="bs-title-option" value="">Şirkəti seçin</option>
                                    @if(!empty($companies[0]))
                                        @foreach($companies as $company)
                                            <option value="{{$company['id']}}">{{$company['name']['az']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fs-input-icon fa fa-globe-americas"></i>
                            </div>
                            <div class="twm-nav-btn-right">
                                <p style="color: red;">*Əgər şirkət seçimiz yoxdursa, zəhmət olmasa şirkətlər bölməsinə daxil olub əlavə edə bilərsiniz.</p>
                            </div>
                        </div>

                    </div>

                    <!--Experience-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Maaş (min)</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control" name="min_salary" type="number" placeholder="300" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon fa fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>

                    <!--Experience-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Maaş (max)</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control" name="max_salary" type="number" placeholder="800">
                                <i class="fs-input-icon fa fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>


                    <!--Email Address-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>E-poçt</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control" name="email" type="email" placeholder="isveren.consulting@gmail.com" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon fas fa-at"></i>
                            </div>
                        </div>
                    </div>

                    <!--Email Address-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Əlaqə nömrəsi</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control" name="phone" type="text" placeholder="+99499 702 70 93" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon fas fa-phone"></i>
                            </div>
                        </div>
                    </div>
                    <!--Start Date-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Əlavə edilmə tarixi</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control datepicker" data-provide="datepicker" name="start_date" type="text" placeholder="mm/dd/yyyy" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon far fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <!--End Date-->
                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Bitmə tarixi</label>
                            <div class="ls-inputicon-box">
                                <input class="form-control datepicker" data-provide="datepicker" name="end_date" type="text" placeholder="mm/dd/yyyy" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                <i class="fs-input-icon far fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <!--End Date-->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="form-group">
                            <label>Premium olsun?</label>
                            <div>
                                <input name="is_premium"  id="is_premium" class="vacancy-option" type="checkbox" value="1">
                                <i class="fs-input-icon far fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="form-group">
                            <label>Ən yeni vakansiya olsun?</label>
                            <div>
                                <input name="is_new"  id="is_new" class="vacancy-option" type="checkbox" value="1">
                                <i class="fs-input-icon far fa-check"></i>
                            </div>
                        </div>
                    </div>
                  
                    <!--Description-->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Daha ətraflı məlumat</label>
                            {{--@if(auth()->guard('web')->user()->id ===2)
                                <textarea class="summernote-height form-control" name="description[az]" rows="3" id="description" placeholder="@lang('web.description')"></textarea>
                            @else--}}
                                <textarea class="summernote-height form-control" rows="3" name="description[az]" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')"></textarea>
{{--                            @endif--}}
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="text-left">
                            <button type="buttonJobSave" class="site-button m-r5">Yadda saxla</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('user.js')
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
    <script>
        document.querySelectorAll('.vacancy-option').forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    // Digər checkbox-ları deaktiv et
                    document.querySelectorAll('.vacancy-option').forEach((cb) => {
                        if (cb !== this) cb.checked = false;
                    });
                }
            });
        });
    </script>
    <script>
        $('#j-category').on('change', function () {
            var categoryId = $(this).val();
            var subCategorySelect = $('#j-sub-category');

            // Alt kateqoriya seçimlərini tamamilə sil
            subCategorySelect.empty();

            // Varsayılan option əlavə et
            subCategorySelect.append('<option value="">Kateqorya seç</option>');

            // Əgər əsas kateqoriya seçilibsə, AJAX ilə alt kateqoriyaları gətir
            if (categoryId) {
                $.ajax({
                    url: '/user/subcategory/' + categoryId,
                    type: 'GET',
                    success: function (response) {
                        // Alt kateqoriya selectini boşalt
                        subCategorySelect.empty();
                        // Əlavə olaraq default option əlavə et (məsələn: "Seçin")
                        // subCategorySelect.append('<option value="">Kateqoriya seç</option>');

                        if (response.length > 0) {
                            $.each(response, function (key, subcategory) {
                                subCategorySelect.append(
                                    '<option value="' + subcategory.id + '">' + subcategory.name.az + '</option>'
                                );
                            });
                        } else {
                            subCategorySelect.append('<option value="">Alt kateqoriya tapılmadı</option>');
                        }
                        subCategorySelect.selectpicker('destroy');
                        subCategorySelect.selectpicker('render');

                        // Selectpicker üçün təzələmə
                        // subCategorySelect.selectpicker('refresh');
                    },

                    error: function () {
                        subCategorySelect.append('<option value="">Xəta baş verdi</option>');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#jobSave').submit(function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                let submitButton = $('#buttonJobSave');

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
