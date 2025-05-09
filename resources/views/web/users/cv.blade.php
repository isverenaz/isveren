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
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/resume.css') }}">
@endsection
@section('user.section')
    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
        <div class="twm-right-section-panel site-bg-gray">

            <!--Resume Headline-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">CV başlığı</h4>
                    <a data-bs-toggle="modal" href="#Resume_Headline" role="button" title="@if(!empty($data['id'])) @lang('site.edit') @else @lang('site.add') @endif" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        <p>{{ $data['title'] ?? 'Qeyd edilməyib' }}</p>
                    </div>
                </div>
                <!--Modal Popup -->
                <div class="modal fade twm-saved-jobs-view" id="Resume_Headline" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvTitle" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">CV başlığı</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group twm-textarea-full">
                                                <input class="form-control" required="required" name="title" id="title" value="{{ $data['title'] ?? '' }}" placeholder="PHP Developer, Ofis Meneceri və s." oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button id="buttonTitle" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($data['title']))
            <!--Personal Details-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Haqqınızda məlumat</h4>
                    <a data-bs-toggle="modal" href="#Personal_Details" role="button" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                @if(!empty($data['gender_status']))
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Doğum tarixi</div>
                                    <span class="twm-s-info-discription">{{date('d.m.Y',strtotime($data['birthday']))}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Cins</div>
                                    <span class="twm-s-info-discription">{{$data['gender_status'] == 1 ? 'Kişi': 'Qadın'}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Ailə vəziyyəti/Uşaq</div>
                                    <span class="twm-s-info-discription">
                                        @if($data['married_status'] == 1)
                                            {{ 'Subay' }}
                                        @elseif($data['married_status'] == 2)
                                            {{ 'Evli' }} / {{'Uşaq '. ($data['is_child'] == 1 ? 'Var': 'Yoxdur')}}
                                        @elseif($data['married_status'] == 3)
                                            {{ 'Boşanmış' }} / {{'Uşaq '. ($data['is_child'] == 1 ? 'Var': 'Yoxdur')}}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Ölkə / Şəhər</div>
                                    <span class="twm-s-info-discription">{{ !empty($data['country']['name'])? json_decode($data['country']['name'])->az: ''}} / {{ $data['city']['name']['az'] ?? ''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Qeydiyyat Ünvanı</div>
                                    <span class="twm-s-info-discription">{{$data['permanent_address'] ?? null}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Faktiki Ünvan</div>
                                    <span class="twm-s-info-discription">{{$data['actual_address'] ?? null}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Əlaqə vasitəsi</div>
                                    <span class="twm-s-info-discription">{{$data['phone'] ?? null}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">E-poçt</div>
                                    <span class="twm-s-info-discription">{{$data['email'] ?? null}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

                <!--Personal Details Modal -->
                <div class="modal fade twm-saved-jobs-view" id="Personal_Details" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvAbout" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Haqqınızda məlumat qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!--Birth Date-->
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Doğum tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker" data-provide="datepicker" name="birthday" type="text" value="{{ !empty($data['birthday']) ? date('m/d/Y', strtotime($data['birthday'])) : '' }}" required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Cins</label>
                                                <div class="row twm-form-radio-inline">

                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" @if($data['gender_status'] == 1) checked="checked" @endif name="gender_status" id="male" value="1">
                                                        <label class="form-check-label" for="male">
                                                            Kişi
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="gender_status" @if($data['gender_status'] != 1) checked="checked" @endif id="female" value="2">
                                                        <label class="form-check-label" for="female">
                                                            Qadın
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Evlilik statusu</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker"  data-live-search="true" name="married_status" title=""  required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')" data-bv-field="size">
                                                        <option class="bs-title-option" value="" @if($data['married_status'] == "") selected="selected" @endif>Evlilik statusu</option>
                                                        <option value="1" @if($data['married_status'] == 1) selected="selected" @endif>Subay</option>
                                                        <option value="2" @if($data['married_status'] == 2) selected="selected" @endif>Evli</option>
                                                        <option value="3" @if($data['married_status'] == 3) selected="selected" @endif>Boşanmış</option>
                                                    </select>
                                                    <i class="fs-input-icon fa fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12" id="">
                                            <div class="form-group">
                                                <label>Uşaq var?</label>
                                                <div class="row twm-form-radio-inline">
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="is_child" @if($data['is_child'] == 1) checked="checked" @endif id="is_child" value="1">
                                                        <label class="form-check-label" for="male">
                                                            Bəli
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" @if($data['is_child'] != 1) checked="checked" @endif name="is_child" id="is_child" value="2">
                                                        <label class="form-check-label" for="is_child">
                                                            Xeyr
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group mb-0">
                                                <label>Ölkə</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker" data-live-search="true" name="country_id" id="country_id"  required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                        <option class="bs-title-option" value="">Hamsı</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country['id'] }}" @if(!empty($data['country_id']) && $country['id'] == $data['country_id']) selected @endif>{{ json_decode($country['name'],0)->az ?? null }}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="fs-input-icon fa fa-globe-americas"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group mb-0">
                                                <label>Şəhər</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker" data-live-search="true" name="city_id" id="city_id" required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                        @if(!empty($data['city']['name']['az']))
                                                            <option value="{{ $data['city']['id'] ?? ''}}">{{ $data['city']['name']['az'] ?? ''}}</option>
                                                        @endif
                                                    </select>
                                                    <i class="fs-input-icon fa fa-globe-americas"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Rəsmi ünvan</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control"  type="text" name="permanent_address" value="{{$data['permanent_address'] ?? null}}"  required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Faktiki ünvan</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control"  type="text" name="actual_address" value="{{$data['actual_address'] ?? null}}" required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Əlaqə vasitəsi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control"  type="text"  name="phone" value="{{$data['phone'] ?? null}}" required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-map-pin"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>E-poçt</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control" type="text" name="email"  value="{{$data['email'] ?? null}}" required="required"  oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa flaticon-email"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Özünüz haqqında qısa məlumat</label>
                                                <textarea class="form-control" rows="3" name="note" placeholder="..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button id="buttonAbout" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @endif

            @if(!empty($data['birthday']))
            <!--Desired Career Profile-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Əlavə məlumatlar</h4>
                    <a data-bs-toggle="modal" href="#Desired_Career" role="button" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                @if(!empty($data['category']['name']['az']))
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Sahəniz</div>
                                    <span class="twm-s-info-discription">{{ $data['category']['name']['az'] ?? ''}} / {{ $data['parentCategory']['name']['az'] ?? ''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">İş rejimi</div>
                                    <span class="twm-s-info-discription">{{$data['workingHour']['name']['az'] ?? null}}</span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">İstədyiniz əmək haqqı</div>
                                    <span class="twm-s-info-discription">{{ $data['min_salary'] ?? '-' }} - {{ $data['max_salary'] ?? '+' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="twm-s-detail-section">
                                    <div class="twm-title">Sizə uyğun ünvan</div>
                                    <span class="twm-s-info-discription">{{ $data['desired_address'] ?? '-' }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                <!--Desired Career Profile -->
                <div class="modal fade twm-saved-jobs-view" id="Desired_Career" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvOtherAbout" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Əlavə məlumat qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <!--Industry-->
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>İş kateqoryanız</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker" name="category_id" id="category_id" data-live-search="true" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" onselect="this.setCustomValidity('')">
                                                        <option value="">- Seçin -</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category['id'] }}" @if(!empty($data['category_id']) && $category['id'] == $data['category_id']) selected="selected" @endif>{{ $category['name']['az'] ?? null }}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="fs-input-icon fa fa-industry"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Industry-->
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Sahəniz</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker" name="parent_category_id" id="parent_category_id" data-live-search="true" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" onselect="this.setCustomValidity('')">
                                                        @if(!empty($data['parentCategory']['id'] ))
                                                            <option value="{{ $data['parentCategory']['id'] ?? ''}}">{{ $data['parentCategory']['name']['az'] ?? ''}}</option>
                                                        @endif
                                                    </select>
                                                    <i class="fs-input-icon fa fa-industry"></i>
                                                </div>
                                            </div>
                                        </div>


                                        <!--Employment Type-->
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>İş rejimi</label>
                                                <div class="row twm-form-radio-inline">
                                                    @foreach($workingHours as $hours)
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio"  name="working_hour" @if(!empty($data['working_hour']) && $data['working_hour'] == $hours['id']) checked="checked" @endif id="{{$hours['code']}}" value="{{$hours['id']}}">
                                                        <label class="form-check-label" for="{{$hours['code']}}">
                                                            {{$hours['name']['az']}}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!--Expected Salary-->
                                        <div class="col-xl-6 col-lg-6">
                                            <div class="form-group">
                                                <label>İstədiyiniz maaş (min)</label>
                                                <input class="form-control" type="number" name="min_salary" value="{{$data['min_salary'] ?? 0 }}" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6">
                                            <div class="form-group">
                                                <label>İstədiyiniz maaş (max)</label>
                                                <input class="form-control" type="number" name="max_salary" value="{{$data['max_salary'] ?? 0 }}">
                                            </div>
                                        </div>


                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Sizə uyğun ünvan</label>
                                                <input class="form-control" type="text" name="desired_address" value="{{ $data['desired_address'] ?? '' }}">
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonOtherAbout" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($data['category_id']))
            <!--Key Skills-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Bacarıqlar</h4>
                    <a data-bs-toggle="modal" href="#Key_Skills" role="button" id="knowledgeAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20">
                    <div class="tw-sidebar-tags-wrap">
                        <div class="tagcloud">
                            @if(!empty($data['skills']))
                            @foreach(json_decode($data['skills'],true) as $skill)
                            <span class="tag">{{$skill}} <button class="remove-tag remove-skill">×</button></span>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!--Modal popup -->
                <div class="modal fade twm-saved-jobs-view" id="Key_Skills" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvSkills" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Bacarıqlarınızı qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input class="form-control"  type="text" placeholder="PHP, Java, SMM, Devops və s" name="skills" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonSkills" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Dill Skills-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Dil biliklər</h4>
                    <a data-bs-toggle="modal" href="#Key_Lang" role="button" id="langAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20">
                    <div class="tw-sidebar-tags-wrap">
                        <div class="tagcloud">
                            @if(!empty($data['language']))
                                @foreach(json_decode($data['language'],true) as $language)
                                    <?php
                                    if($language['currentlyWorked'] == 'excellent'){
                                        $currentlyWorked = 'Əla';
                                    }elseif($language['currentlyWorked'] == 'average'){
                                        $currentlyWorked = 'Yaxşı';
                                    }else {
                                        $currentlyWorked = 'Zəif';
                                    }
                                    ?>
                                    <span class="tag">{{$language['name']}}-{{$currentlyWorked}} <button class="remove-tag remove-language">×</button></span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!--Modal popup -->
                <div class="modal fade twm-saved-jobs-view" id="Key_Lang" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvLanguage" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Dil biliklərinizi qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <input class="form-control"  type="text" placeholder="Azərbaycan dili" name="language[name]" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Hansı səviyyə</label>
                                            <div class="row twm-form-radio-inline">
                                                <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" value="weak" name="language[currentlyWorked]">
                                                    <label class="form-check-label" for="yesCurrentlyWorked">
                                                        Zəif
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" value="average"  name="language[currentlyWorked]">
                                                    <label class="form-check-label" for="noCurrentlyWorked">
                                                        Yaxşı
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" value="excellent"  name="language[currentlyWorked]">
                                                    <label class="form-check-label" for="noCurrentlyWorked">
                                                        Əla
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonLanguage" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Employment-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">İş təcrübəsi</h4>
                    <a data-bs-toggle="modal" href="#Employment" role="button" id="employmentAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        @if(!empty($data['experience']))
                            @foreach(json_decode($data['experience'],true) as $experience)
                                <p><b>{{$experience['position']}} - {{$experience['company']}}</b><button class="remove-tag remove-experience">×</button></p>
                                <p>{{$experience['skill_start_date']}} - {{!empty($experience['currentlyWorked'])? 'Isleyir':$experience['skill_end_date']}}</p>
                                <p>{{$experience['skill_text']}}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!--Employment -->
                <div class="modal fade twm-saved-jobs-view" id="Employment" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvEmployment" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">İş təcrübənizi qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Şirkət </label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control"  type="text" name="employment[company]" placeholder="İş Verən Consulting" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-address-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Vəzifə</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control" type="text" name="employment[position]" placeholder="Backend Developer" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-building"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Start Date-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Başlama tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker" data-provide="datepicker" name="employment[skill_start_date]" type="text" placeholder="mm/dd/yyyy" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Hal-hazırda işləyirsiz?</label>
                                                <div class="row twm-form-radio-inline">
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="employment[currentlyWorked]" value="1" id="yesCurrentlyWorked">
                                                        <label class="form-check-label" for="yesCurrentlyWorked">
                                                            Bəli
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="employment[currentlyWorked]" value="0" id="noCurrentlyWorked">
                                                        <label class="form-check-label" for="noCurrentlyWorked">
                                                            Xeyir
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12" id="workedDateField">
                                            <div class="form-group">
                                                <label>Çıxma tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker" data-provide="datepicker" name="employment[skill_end_date]" type="text" placeholder="mm/dd/yyyy">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label>Fəaliyyətiniz haqqda qısa məlumat</label>
                                                <textarea class="form-control" rows="3"  name="employment[skill_text]" placeholder="...." required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonEmployment" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!--Education-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Təhsil</h4>
                    <a data-bs-toggle="modal" href="#Education" role="button" id="educationAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        @if(!empty($data['education']))
                            @foreach(json_decode($data['education'],true) as $education)
                                <p><b>{{$education['specialization']}}-{{$education['name']}}</b><button class="remove-tag remove-education">×</button></p>
                                <p>{{$education['education_start_date']}} - {{!empty($education['currentlyStudying'])? 'Oxuyur':$education['education_end_date']}}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!--Education -->
                <div class="modal fade twm-saved-jobs-view" id="Education" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvEducation" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Təhsiliniz haqqında qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Təhsil dərəcəsi</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker" name="education[level]"  data-live-search="true" title="" data-bv-field="size" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                        <option class="bs-title-option" value="">-Zəhmət olmasa təhsil dərəcəsi seçin</option>
                                                        <option value="1">Ümumi Orta Təhsil</option>
                                                        <option value="2">Orta İxtisas Təhsili</option>
                                                        <option value="3">Bakalavr</option>
                                                        <option value="4">Magistratura</option>
                                                        <option value="5">Doktorantura</option>
                                                    </select>
                                                    <i class="fs-input-icon fa fa-user-graduate"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Təhsil müəsəssi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control"  type="text" name="education[name]" placeholder="Təhsil müəssəsinin adını qeyd edin" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-book-reader"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>İxtisasınız</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control"  type="text" name="education[specialization]" placeholder="İxtisasınızı qeyd edin" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-book"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Başlama tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker" data-provide="datepicker" name="education[education_start_date]" type="text" placeholder="mm/dd/yyyy" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Hal-hazırda təhsil alırsız?</label>
                                                <div class="row twm-form-radio-inline">
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="education[currentlyStudying]" value="1" id="yesCurrentlyStudying">
                                                        <label class="form-check-label" for="yesCurrentlyStudying">
                                                            Bəli
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="education[[currentlyStudying]" value="0" id="noCurrentlyStudying">
                                                        <label class="form-check-label" for="noCurrentlyStudying">
                                                            Xeyir
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12" id="graduationDateField">
                                            <div class="form-group">
                                                <label>Bitirmə tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker" data-provide="datepicker" name="education[education_end_date]" type="text" placeholder="mm/dd/yyyy">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonEducation" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!--Project-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">İştirak etdiyiniz lahiyələr</h4>
                    <a data-bs-toggle="modal" href="#Pro_ject" role="button" id="projectAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        @if(!empty($data['projects']))
                            @foreach(json_decode($data['projects'],true) as $project)
                                <p><b>{{$project['name']}}</b><button class="remove-tag remove-project">×</button></p>
                                <p>{{$project['project_start_date']}} - {{!empty($project['currentlyProject'])? 'Isleyir':$project['project_end_date']}} - {{$project['is_who'] == 1 ? 'Oz lahiyem':'Müşdəri lahiyəsi'}}</p>
                                <p>{{$project['project_text']}}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!--Project -->
                <div class="modal fade twm-saved-jobs-view" id="Pro_ject" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvProject" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">İştirak etdiyiniz lahiyəni qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Lahiyə adı</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control" name="project[name]" type="text" placeholder="İş verən Consulting" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon fa fa-address-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Lahiyə kimindir?</label>
                                                <div class="ls-inputicon-box">
                                                    <select class="wt-select-box selectpicker"  name="project[is_who]" data-live-search="true" title=""  data-bv-field="size" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                        <option class="bs-title-option" value="">-Seçin</option>
                                                        <option value="1">Öz lahiyəm</option>
                                                        <option value="2">Müşdəri lahiyəsi</option>
                                                    </select>
                                                    <i class="fs-input-icon fa fa-user-graduate"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Start Date-->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Başlama tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker"  name="project[project_start_date]" data-provide="datepicker" type="text" placeholder="mm/dd/yyyy" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Hal-hazırda davam edir?</label>
                                                <div class="row twm-form-radio-inline">
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="project[currentlyProject]" value="1" id="yesCurrentlyProject">
                                                        <label class="form-check-label" for="yesCurrentlyProject">
                                                            Bəli
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-check-input" type="radio" name="project[currentlyProject]" value="0" id="noCurrentlyProject">
                                                        <label class="form-check-label" for="noCurrentlyProject">
                                                            Xeyir
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12" id="projectDateField">
                                            <div class="form-group">
                                                <label>Bitmə tarixi</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control datepicker" data-provide="datepicker" name="project[project_end_date]" type="text" placeholder="mm/dd/yyyy">
                                                    <i class="fs-input-icon far fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label>Fəaliyyətiniz haqqda qısa məlumat</label>
                                                <textarea class="form-control" rows="3"  name="project[project_text]" placeholder="...." required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonProject" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!--Hobby-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Hobbi</h4>
                    <a data-bs-toggle="modal" href="#Key_Hobby" role="button" id="hobbyAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20">
                    <div class="tw-sidebar-tags-wrap">
                        <div class="tagcloud">
                            @if(!empty($data['hobby']))
                                @foreach(json_decode($data['hobby'],true) as $hobby)
                                    <span class="tag">{{$hobby}} <button class="remove-tag remove-hobby">×</button></span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!--Modal popup -->
                <div class="modal fade twm-saved-jobs-view" id="Key_Hobby" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvHobby" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Hobinizi qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <input class="form-control" name="hobby" type="text" placeholder="Kitab oxumaq" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonHobby" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Social-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Sosial şəbəkə ünvanları</h4>
                    <a data-bs-toggle="modal" href="#Key_Social" role="button" id="socialAdd" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20">
                    <div class="tw-sidebar-tags-wrap">
                        <div class="tagcloud">
                            @if(!empty($data['socials']))
                                @foreach(json_decode($data['socials'],true) as $social)
                                    <span class="tag"><a href="{{$social['link']}}" target="_blank">{{$social['name']}}</a> <button class="remove-tag remove-social">×</button></span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!--Modal popup -->
                <div class="modal fade twm-saved-jobs-view" id="Key_Social" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvSocial" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Sosial şəbəkə ünvanızı qeyd edin</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Hansı sosial şəbəkə?</label>
                                            <div class="ls-inputicon-box">
                                                <select class="wt-select-box selectpicker" name="social[name]" data-live-search="true" title="" data-bv-field="size" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                                    <option class="bs-title-option" value="">-Zəhmət olmasa sosial şəbəkə ünvanı seçin</option>
                                                    <option value="linkedin">Linkedin</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="whatsapp">Whatsapp</option>
                                                    <option value="telegram">Telegram</option>
                                                    <option value="tiktok">Tiktok</option>
                                                    <option value="instagram">Instagram</option>
                                                </select>
                                                <i class="fs-input-icon fa fa-user-graduate"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <label>Link</label>
                                        <div class="form-group">
                                            <input class="form-control"  name="social[link]" type="text" placeholder="https://linkedin.com" required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonSocial" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Öz cv-nizi əlavə edin @if(!empty($data['resume'])) ( Əlavə edilən cv-i: <span><a href="{{ asset("uploads/user/resume/".$data['resume']) }}" target="_blank">{{$data['resume']}}</a></span>)@endif </h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        <form id="cvResume" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="upload-btn-wrapper">
                                <style>
                                    .custom-file-upload {
                                        position: relative;
                                        display: inline-block;
                                        padding: 12px 20px;
                                        background-color: #f3f6ff;
                                        color: #333;
                                        border: 2px dashed #cdd6f3;
                                        border-radius: 12px;
                                        cursor: pointer;
                                        width: 100%;
                                        text-align: center;
                                        font-weight: 500;
                                        transition: all 0.3s ease;
                                    }

                                    .custom-file-upload:hover {
                                        background-color: #e1e9ff;
                                    }

                                    .custom-file-upload i {
                                        margin-right: 8px;
                                    }

                                    #resume {
                                        display: none;
                                    }

                                    #file-name {
                                        display: block;
                                        margin-top: 10px;
                                        font-style: italic;
                                        color: #666;
                                    }
                                </style>

                                <div class="form-group">
                                    <label for="resume" class="custom-file-upload">
                                        <i class="fas fa-upload"></i> CV @if(!empty($data['resume'])) yenilə @else əlavə et @endif
                                    </label>
                                    <input class="form-control" name="resume" id="resumeButton" type="file" accept=".pdf,.doc,.docx">
                                    <small class="text-danger error-message" id="resume-error"></small>
                                </div>
                                {{--<div id="upload-image-grid" style="width: 0px; height: 0px;"></div>
                                <button type="button" class="site-button resume-button button-sm"> @if(!empty($data['resume'])) Yenilə @else Əlavə et @endif</button>
                                <input type="file" name="resume" id="resumeButton" accept=".pdf, .docx">--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--motivation_letter Summary-->
            <div class="panel panel-default mb-3">
                <div class="panel-heading wt-panel-heading p-a20 panel-heading-with-btn ">
                    <h4 class="panel-tittle m-a0">Motivasiya məktubu</h4>
                    <a data-bs-toggle="modal" href="#Profile_Summary" role="button" title="Edit" class="site-text-primary">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
                <div class="panel-body wt-panel-body p-a20 ">
                    <div class="twm-panel-inner">
                        <p>{!! $data['motivation_letter'] ?? 'Qeyd edilməyib' !!}</p>
                    </div>
                </div>
                <!--Modal Popup -->
                <div class="modal fade twm-saved-jobs-view" id="Profile_Summary" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="cvMotivation" action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="modal-header">
                                    <h2 class="modal-title">Motivasiya məktubu</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group twm-textarea-full">
                                                <textarea class="form-control" name="motivation_letter" placeholder="..." required="required" oninvalid="this.setCustomValidity('Zəhmət olmasa, bu sahəni doldurun.')" oninput="this.setCustomValidity('')">{!! $data['motivation_letter'] ?? '' !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="site-button" data-bs-dismiss="modal">Bağla</button>
                                    <button type="buttonMotivation" class="site-button">Yadda saxla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('user.js')
    @include('web.users.cv-js')
    <script>
        $('#country_id').on('change', function () {
            let countryId = $(this).val();
            let cityDropdown = $('#city_id');
            cityDropdown.empty();
            // Şəhər dropdown-u təmizləyirik
            cityDropdown.empty().append('<option value="">Şəhər</option>'); // Yeni seçilən ölkəyə uyğun seçim

            // Əgər əsas kateqoriya seçilibsə, AJAX ilə alt kateqoriyaları gətir
            if (countryId) {
                $.ajax({
                    url: '/user/cv/cities',
                    type: 'GET',
                    data: {country_id: countryId},
                    success: function (response) {
                        // Alt kateqoriya selectini boşalt
                        cityDropdown.empty();
                        // Əlavə olaraq default option əlavə et (məsələn: "Seçin")
                        // subCategorySelect.append('<option value="">Kateqoriya seç</option>');

                        if (response.length > 0) {
                            $.each(response, function (key, city) {
                                cityDropdown.append('<option value="' + city.id + '">' + city.name.az + '</option>');
                            });
                        } else {
                            cityDropdown.append('<option value="">Şəhər tapılmadı</option>');
                        }
                        cityDropdown.selectpicker('destroy');
                        cityDropdown.selectpicker('render');

                        // Selectpicker üçün təzələmə
                        // subCategorySelect.selectpicker('refresh');
                    },

                    error: function () {
                        cityDropdown.append('<option value="">Xəta baş verdi</option>');
                    }
                });
            }
        });
        $('#category_id').on('change', function () {
            var categoryId = $(this).val();
            var subCategorySelect = $('#parent_category_id');

            // Alt kateqoriya seçimlərini tamamilə sil
            subCategorySelect.empty();

            // Varsayılan option əlavə et
            subCategorySelect.append('<option value="">Kateqorya seç</option>');

            // Əgər əsas kateqoriya seçilibsə, AJAX ilə alt kateqoriyaları gətir
            if (categoryId) {
                $.ajax({
                    url: '/user/cv/parent-categories',
                    type: 'GET',
                    data: {parent_id: categoryId},
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
@endsection
