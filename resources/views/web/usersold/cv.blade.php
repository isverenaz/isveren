@extends('web.users.user-menu')
@section('user.css')
    <link href="{{ asset('user/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('user/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    <style>
        .upload-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            margin: auto;
        }

        .upload-container input[type="file"] {
            display: none;
        }

        .upload-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .upload-container img {
            margin-top: 20px;
            max-width: 100%;
            height: auto;
            display: none;
        }
    </style>
    <style>
        .cv-upload-container {
            margin: 20px;
            padding: 3px;
            border: 1px solid #ccc;
            border-radius: 7px;
            text-align: center;
            max-width: 400px;
            margin: auto;
        }

        .cv-upload-container input[type="file"] {
            display: none;
        }

        .cv-upload-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .cv-file-name {
            margin-top: 5px;
            font-size: 16px;
            font-style: italic;
        }
    </style>
    <style>
        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 16px;
        }

        .checkbox-container input[type="checkbox"] {
            display: none;
        }

        .checkbox-custom {
            width: 24px;
            height: 24px;
            background-color: #f0f0f0;
            border: 2px solid #ddd;
            border-radius: 4px;
            display: inline-block;
            position: relative;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .checkbox-container input[type="checkbox"]:checked + .checkbox-custom {
            background-color: #007bff;
            border-color: #007bff;
        }

        .checkbox-container input[type="checkbox"]:checked + .checkbox-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background-color: #fff;
            border-radius: 2px;
            transform: translate(-50%, -50%);
        }

        .checkbox-label {
            color: #333;
        }
    </style>
@endsection
@section('user.section')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Cv yarat</h4>
                    </div>
                </div>
            </div>
            @if (Session::get('errors'))
                @if(!empty(Session::get('errors')) && is_array(json_decode(Session::get('errors'), true)))
                    @foreach(json_decode(Session::get('errors'), true) as $key=>$error)
                        <div class="col-12 mt-1">
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-body">{{ $error[0] }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 mt-1">
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-body">{{ Session::get('errors') }}</div>
                        </div>
                    </div>
                @endif
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
                            <form
                                action="{{ !empty($data)?route('web.user.cv.update',$data['id']):route('web.user.cv.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($data))
                                    @method('PUT')
                                @endif
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <img id="preview"
                                             src="{{ !empty($data['image'])? asset('uploads/cv/'.$data['image']): asset('user/user.png') }}"
                                             alt="İstifadəçi profil - isveren.az"
                                             style="max-width: 121px; max-height: 96px; border-radius: 100px;!important;">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="upload-container">
                                            <label for="file-upload" class="upload-label">Şəkil Seçin</label>
                                            <input type="file" name="image" id="file-upload" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <input id="name" name="name" type="text" class="form-control"
                                               value="{!! !empty($data['name'])? $data['name']: '' !!}"
                                               placeholder="@lang('web.name')">
                                    </div>
                                    <div class="col-lg-6">
                                        <input id="surname" name="surname" type="text" class="form-control"
                                               value="{!! !empty($data['surname'])? $data['surname']: '' !!}"
                                               placeholder="@lang('web.surname')">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <input id="birthday" name="birthday" type="date" class="form-control"
                                               value="{!! !empty($data['birthday'])? $data['birthday']: '' !!}"
                                               placeholder="@lang('web.birthday')">
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="gender" id="input-gender">
                                            <option value="">Cins</option>
                                            <option value="man"
                                                    @if(!empty($data['gender']) && $data['gender'] == 1) selected @endif>
                                                Kişi
                                            </option>
                                            <option value="woman"
                                                    @if(!empty($data['gender']) && $data['gender'] == 2) selected @endif>
                                                Qadın
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="marriage"
                                                   @if(!empty($data['marriage']) && $data['marriage']==1) checked
                                                   @endif value="1">
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-label">Evlisiz?</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="city_id" id="input-city">
                                            <option value="">@lang('web.city_choose')</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}"
                                                        @if(!empty($data['city_id']) && $data['city_id'] == $city->id) selected @endif>{{ json_decode($city, true)['name']['az'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <input id="email" name="email" type="text" class="form-control"
                                               value="{!! !empty($data['email'])? $data['email']: '' !!}"
                                               placeholder="@lang('web.email')">
                                    </div>
                                    <div class="col-lg-6">
                                        <input id="phone" name="phone" type="text" class="form-control"
                                               value="{!! !empty($data['phone'])? $data['phone']: '' !!}"
                                               placeholder="@lang('web.phone')">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-14">
                                        <textarea class="summernote-height form-control" name="description" rows="2"
                                                  placeholder="@lang('web.user_description')">
                                            {!! !empty($data['description'])? $data['description']: '' !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control"
                                               placeholder="@lang('web.min_salary')" name="min_salary"
                                               value="{!! !empty($data['min_salary'])? $data['min_salary']: '' !!}"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control"
                                               placeholder="@lang('web.max_salary')" name="max_salary"
                                               value="{!! !empty($data['max_salary'])? $data['max_salary']: '' !!}"/>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <select class="form-control" name="profession_id" id="input-type">
                                            <option value="">İxtisas seç</option>
                                            @foreach($professions as $profession)
                                                <option value="{{$profession->id}}"
                                                        @if(!empty($data['profession_id']) && $data['profession_id'] == $profession->id) selected @endif>
                                                    {{ json_decode($profession, true)['title']['az'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <select class="form-control" name="category_id">
                                            <option value="">Əsas kateqorya seç</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"
                                                        @if(!empty($data['category_id']) && $data['category_id'] == $category->id) selected @endif>
                                                    {{ json_decode($category, true)['name']['az'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="sub_category_id">
                                            <option value="">Kateqorya seç</option>
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{$subcategory->id}}"
                                                        @if(!empty($data['sub_category_id']) && $data['sub_category_id'] == $subcategory->id) selected @endif>
                                                    {{ json_decode($subcategory, true)['name']['az'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-3">
                                        <select name="work_exp" class="form-control">
                                            <option value="0"
                                                    @if(!empty($data['work_exp']) && $data['work_exp'] == 0) selected @endif>
                                                İş stajı seçin
                                            </option>
                                            <option value="1"
                                                    @if(!empty($data['work_exp']) && $data['work_exp'] == 1) selected @endif>
                                                1 ildən az
                                            </option>
                                            <option value="2"
                                                    @if(!empty($data['work_exp']) && $data['work_exp'] == 2) selected @endif>
                                                1 ildən 3 ilə qədər
                                            </option>
                                            <option value="3"
                                                    @if(!empty($data['work_exp']) && $data['work_exp'] == 3) selected @endif>
                                                3 ildən 5 ilə qədər
                                            </option>
                                            <option value="4"
                                                    @if(!empty($data['work_exp']) && $data['work_exp'] == 4) selected @endif>
                                                5 ildən yüksək
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select name="education_type" class="form-control">
                                            <option value="0"
                                                    @if(!empty($data['education_type']) && $data['education_type'] == 0) selected @endif>
                                                Təhsil statusu seçin
                                            </option>
                                            <option value="2"
                                                    @if(!empty($data['education_type']) && $data['education_type'] == 2) selected @endif>
                                                Ali
                                            </option>
                                            <option value="3"
                                                    @if(!empty($data['education_type']) && $data['education_type'] == 3) selected @endif>
                                                Natamam ali
                                            </option>
                                            <option value="6"
                                                    @if(!empty($data['education_type']) && $data['education_type'] == 6) selected @endif>
                                                Orta
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-control" name="type_id" id="input-type">
                                            <option value="">@lang('web.type_choose')</option>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}"
                                                        @if(!empty($data['type_id']) && $data['type_id'] == $type->id) selected @endif>
                                                    {{ json_decode($type, true)['name']['az'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="cv-upload-container">
                                            <div id="cv-file-name" class="cv-file-name"><label for="cv-file-upload">Cv
                                                    əlavə et</label></div>
                                            <input type="file" name="cv_file" id="cv-file-upload" accept=".pdf,.docx">

                                        </div>
                                        @if(!empty($data['cv_file']))
                                            <div class="mb-sm-0 font-size-18">
                                                <a href="{{asset('uploads/cv/'.$data['cv_file'])}}" target="_blank">Cv-ə
                                                    bax</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <h4 class="mb-sm-0 font-size-18">Təhsil</h4>
                                <br>
                                <div class="row mb-4">
                                    <div class="col-lg-3">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="not_education"
                                                   @if(!empty($data['id']) && empty($data['education'])) checked @endif  value="1">
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-label">Təhsilim yoxdur</span>
                                        </label>
                                    </div>
                                </div>
                                <div id="inputTemplateUniversity"
                                     @if(empty($data['education'])) style="display:none;" @endif>
                                    @if(!empty($data['education']))
                                        @foreach(json_decode($data,true)['education'] as $index => $educations)
                                            <div class="row mb-4">
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" placeholder="Müəsə adı"
                                                           name="education[{{$index}}][name]"
                                                           value="{!! !empty($educations['name'] )? $educations['name'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" placeholder="Ixtisas adı"
                                                           name="education[{{$index}}][specialty_name]"
                                                           value="{!! !empty($educations['specialty_name'] )? $educations['specialty_name'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control"
                                                           placeholder="Daxil olduqunuz il"
                                                           name="education[{{$index}}][start_date]"
                                                           value="{!! !empty($educations['start_date'] )? $educations['start_date'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control"
                                                           placeholder="Bitirdiyiniz il"
                                                           name="education[{{$index}}][end_date]"
                                                           value="{!! !empty($educations['end_date'] )? $educations['end_date'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="checkbox-container">
                                                        <input type="checkbox" name="now_reading"
                                                               @if(empty($educations['end_date'])) checked
                                                               @endif value="1">
                                                        <span class="checkbox-custom"></span>
                                                        <span class="checkbox-label">Hal-hazırda təhsil alıram</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div id="inputContainerUniversity"></div>
                                <button type="button" class="btn btn-success mb-4" id="addInputUniversity">+</button>

                                <h4 class="mb-sm-0 font-size-18">İş təcrübəsi</h4>
                                <br>
                                <div class="row mb-4">
                                    <div class="col-lg-3">
                                        <label class="checkbox-container">
                                            <input type="checkbox" id="control-checkbox" name="not_work_exp"
                                                   @if(!empty($data['id']) && empty($data['work_experience'])) checked @endif value="1">
                                            <span class="checkbox-custom"></span>
                                            <span class="checkbox-label">İş təcrübəm yoxdur</span>
                                        </label>
                                    </div>
                                </div>
                                <div id="inputTemplateExperiences"
                                     @if(empty($data['work_experience'])) style="display:none;" @endif>
                                    @if(!empty($data['work_experience']))
                                        @foreach(json_decode($data,true)['work_experience'] as $indexExperiences => $experiences)
                                            <div class="row mb-4">
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" placeholder="Şirkətin adı"
                                                           name="experiences[{{$indexExperiences}}][company]"
                                                           value="{!! !empty($experiences['company'])? $experiences['company'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" placeholder="Vəzifə adı"
                                                           name="experiences[{{$indexExperiences}}][position]"
                                                           value="{!!  !empty($experiences['position'])? $experiences['position'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" placeholder="Başlama tarixi"
                                                           name="experiences[{{$indexExperiences}}][start_date]"
                                                           value="{!!  !empty($experiences['start_date'])? $experiences['start_date'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" placeholder="Bitmə tarixi"
                                                           name="experiences[{{$indexExperiences}}][end_date]"
                                                           value="{!!  !empty($experiences['end_date'])? $experiences['end_date'] : NULL !!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="checkbox-container">
                                                        <input type="checkbox" name="now_reading"
                                                               @if(empty($experiences['end_date'])) checked
                                                               @endif value="1">
                                                        <span class="checkbox-custom"></span>
                                                        <span class="checkbox-label">Hal-hazırda işləyirəm</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div id="inputContainerExperiences"></div>
                                <button type="button" class="btn btn-success mb-4" id="addInputExperiences">+
                                </button>
                                <div class="row mb-5">
                                    <div class="col-lg-2">
                                        <h2 class="profile__section__title">Sürücülük vəsiqəsi</h2>
                                    </div>
                                    <div class="tab_inners">
                                        <div class="profile__add-cv__block first-child">
                                            <div class="row mb-5">
                                                <div class="col-lg-1">
                                                    <label class="checkbox-container">
                                                        <input type="checkbox" value="A"
                                                               @if(!empty($data['driving_license']) && in_array("A",$data['driving_license'])) checked
                                                               @endif id="a" name="drive[]">
                                                        <span class="checkbox-custom"></span>
                                                        <label for="a">A</label>
                                                    </label>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label class="checkbox-container">
                                                        <input value="B" type="checkbox"
                                                               @if(!empty($data['driving_license']) && in_array("B",$data['driving_license'])) checked
                                                               @endif id="b" name="drive[]">
                                                        <span class="checkbox-custom"></span>
                                                        <label for="b">B</label>
                                                    </label>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label class="checkbox-container">
                                                        <input value="C" type="checkbox"
                                                               @if(!empty($data['driving_license']) && in_array("C",$data['driving_license'])) checked
                                                               @endif id="c" name="drive[]">
                                                        <span class="checkbox-custom"></span>
                                                        <label for="c">C</label>
                                                    </label>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label class="checkbox-container">
                                                        <input value="D" type="checkbox"
                                                               @if(!empty($data['driving_license']) && in_array("D",$data['driving_license'])) checked
                                                               @endif id="d" name="drive[]">
                                                        <span class="checkbox-custom"></span>
                                                        <label for="d">D</label>
                                                    </label>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label class="checkbox-container">
                                                        <input value="E" type="checkbox"
                                                               @if(!empty($data['driving_license']) && in_array("E",$data['driving_license'])) checked
                                                               @endif id="e" name="drive[]">
                                                        <span class="checkbox-custom"></span>
                                                        <label for="e">E</label>
                                                    </label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="checkbox-container">
                                                        <input type="checkbox" id="have-car" value="personal_car"
                                                               @if(!empty($data['driving_license']) && in_array("personal_car",$data['driving_license'])) checked
                                                               @endif  name="drive[]">
                                                        <span class="checkbox-custom"></span>
                                                        <label for="have-car">Şəxsi avtomobilim var</label>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <h4 class="mb-sm-0 font-size-18">Sertifkatlar</h4>
                                        <br>
                                        <div id="inputTemplateAwardsCertificates"
                                             @if(empty($data['diploma_certificate'])) style="display:none;" @endif>
                                            @if(!empty($data['diploma_certificate']))
                                                @foreach(json_decode($data, true)['diploma_certificate'] as $indexAwardsCertificates => $AwardsCertificates)
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Sertifkatın adı"
                                                                   name="awards[{{$indexAwardsCertificates}}][certificates_name]"
                                                                   value="{!! !empty($AwardsCertificates['certificates_name']) ? $AwardsCertificates['certificates_name'] : '' !!}"/>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="date" class="form-control"
                                                                   placeholder="Verilmə tarixi"
                                                                   name="awards[{{$indexAwardsCertificates}}][certificates_date]"
                                                                   value="{!! !empty($AwardsCertificates['certificates_date']) ? $AwardsCertificates['certificates_date'] : '' !!}"/>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="inputContainerAwardsCertificates"></div>
                                        <button type="button" class="btn btn-success mb-4"
                                                id="addInputAwardsCertificates">+
                                        </button>

                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="mb-sm-0 font-size-18">Portfolio</h4>
                                        <br>
                                        <div id="inputTemplatePortfolio"
                                             @if(empty($data['portfolio'])) style="display:none;" @endif>
                                            @if(!empty($data['portfolio']))
                                                @foreach(json_decode($data,true)['portfolio'] as $indexPortfolio => $portfolio)
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Portfolio adı"
                                                                   name="portfolio[{{$indexPortfolio}}][portfolio_name]"
                                                                   value="{!! !empty($portfolio['portfolio_name'])? $portfolio['portfolio_name'] : NULL !!}"/>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Portfolio linki"
                                                                   name="portfolio[{{$indexPortfolio}}][portfolio_link]"
                                                                   value="{!! !empty($portfolio['portfolio_link'])? $portfolio['portfolio_link'] : NULL !!}"/>
                                                        </div>
                                                    </div>`
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="inputContainerPortfolio"></div>
                                        <button type="button" class="btn btn-success mb-4" id="addInputPortfolio">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <h4 class="mb-sm-0 font-size-18">Biliklər</h4>
                                        <br>
                                        <div id="inputTemplateSkill"
                                             @if(empty($data['work_skills'])) style="display:none;" @endif>
                                            @if(!empty($data['work_skills']))
                                                @foreach(json_decode($data,true)['work_skills'] as $indexSkills => $skills)
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" placeholder="Skill"
                                                                   name="skill[{{$indexSkills}}]"
                                                                   value="{{ !empty($skills)? $skills : NULL }}"/>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="inputContainerSkill"></div>
                                        <button type="button" class="btn btn-success mb-4" id="addInputSkill">
                                            +
                                        </button>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="mb-sm-0 font-size-18">Dil bilikləri</h4>
                                        <br>
                                        <div id="inputTemplateLangSkill"
                                             @if(empty($data['language_skills'])) style="display:none;" @endif>
                                            @if(!empty($data['language_skills']))
                                                @foreach(json_decode($data,true)['language_skills'] as $indexLangSkills => $langskills)
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4">
                                                            <select class="form-control"
                                                                    name="lang[{{$indexLangSkills}}][lang]">
                                                                <option value=""
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] == "") selected @endif>
                                                                    Dilin adı
                                                                </option>
                                                                <option value="1"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==1) selected @endif>
                                                                    Azərbaycan dili
                                                                </option>
                                                                <option value="2"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==2) selected @endif>
                                                                    Rus dili
                                                                </option>
                                                                <option value="3"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==3) selected @endif>
                                                                    İngilis dili
                                                                </option>
                                                                <option value="4"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==4) selected @endif>
                                                                    Türk dili
                                                                </option>
                                                                <option value="5"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==5) selected @endif>
                                                                    Alman dili
                                                                </option>
                                                                <option value="6"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==6) selected @endif>
                                                                    Fransız dili
                                                                </option>
                                                                <option value="7"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==7) selected @endif>
                                                                    İspan dili
                                                                </option>
                                                                <option value="8"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==8) selected @endif>
                                                                    Çin dili (Mandarin)
                                                                </option>
                                                                <option value="9"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==9) selected @endif>
                                                                    Ərəb dili
                                                                </option>
                                                                <option value="10"
                                                                        @if(!empty($langskills['lang']) && $langskills['lang'] ==10) selected @endif>
                                                                    Portuqal dili
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <select class="form-control"
                                                                    name="lang[{{$indexLangSkills}}][levels]">
                                                                <option value="0"
                                                                        @if(!empty($langskills['levels']) && $langskills['levels'] =="") selected @endif>
                                                                    Səviyyəniz
                                                                </option>
                                                                <option value="1"
                                                                        @if(!empty($langskills['levels']) && $langskills['levels']==1) selected @endif>
                                                                    Zəif
                                                                </option>
                                                                <option value="2"
                                                                        @if(!empty($langskills['levels']) && $langskills['levels']==2) selected @endif>
                                                                    Orta
                                                                </option>
                                                                <option value="3"
                                                                        @if(!empty($langskills['levels']) && $langskills['levels']==3) selected @endif>
                                                                    Yaxşı
                                                                </option>
                                                                <option value="4"
                                                                        @if(!empty($langskills['levels']) && $langskills['levels']==4) selected @endif>
                                                                    Əla
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="inputContainerLangSkill"></div>
                                        <button type="button" class="btn btn-success mb-4" id="addInputLangSkill"> +
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit"
                                            class="btn btn-primary waves-effect waves-light">@lang('web.save')</button>
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
    <script>
        document.getElementById('file-upload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        document.getElementById('cv-file-upload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('cv-file-name').textContent = file.name;
            } else {
                document.getElementById('cv-file-name').textContent = '';
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#addInputUniversity').click(function () {
                var indexUniversity  = $('#inputTemplateUniversity .row').length+ $('#inputContainerUniversity .row').length;
                var newUniversityIndex = indexUniversity;
                var newInputUniversity = `
                <div class="row mb-4">
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Müəsə adı" name="education[${newUniversityIndex}][name]"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Ixtisas adı" name="education[${newUniversityIndex}][specialty_name]"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" placeholder="Daxil olduqunuz il" name="education[${newUniversityIndex}][start_date]"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" placeholder="Bitirdiyiniz il" name="education[${newUniversityIndex}][end_date]"/>
                    </div>
                    <div class="col-lg-2">
                        <label class="checkbox-container">
                            <input type="checkbox" name="education[${newUniversityIndex}][now_reading]" value="1">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Hal-hazırda təhsil alıram</span>
                        </label>
                    </div>
                </div>`;
                $('#inputContainerUniversity').append(newInputUniversity);
            });
            $('#addInputExperiences').click(function () {
                var indexExperiences  = $('#inputTemplateExperiences .row').length+ $('#inputContainerExperiences .row').length;
                var newExperiencesIndex = indexExperiences;
                var newInputExperiences = `
                <div class="row mb-4">
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Şirkətin adı"
                               name="experiences[${newExperiencesIndex}][company]"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Vəzifə adı"
                               name="experiences[${newExperiencesIndex}][position]"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" placeholder="Başlama tarixi"
                               name="experiences[${newExperiencesIndex}][start_date]"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" placeholder="Bitmə tarixi"
                               name="experiences[${newExperiencesIndex}][end_date]"/>
                    </div>
                    <div class="col-lg-2">
                        <label class="checkbox-container">
                            <input type="checkbox" name="experiences[${newExperiencesIndex}][now_work]" value="1">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Hal-hazırda işləyirəm</span>
                        </label>
                    </div>
                </div>`;
                $('#inputContainerExperiences').append(newInputExperiences);
            });
            $('#addInputAwardsCertificates').click(function () {
                // Calculate the number of existing rows (server-rendered and dynamically added)
                var existingRowsCount = $('#inputTemplateAwardsCertificates .row').length + $('#inputContainerAwardsCertificates .row').length;
                var newIndex = existingRowsCount;
                var newInputAwardsCertificates = `
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <input type="text" class="form-control"
                                   placeholder="Sertifkatın adı"
                                   name="awards[${newIndex}][certificates_name]"/>
                        </div>
                        <div class="col-lg-4">
                            <input type="date" class="form-control" placeholder="Verilmə tarixi"
                                   name="awards[${newIndex}][certificates_date]"/>
                        </div>
                    </div>`;
                // Append the new input group to the container
                $('#inputContainerAwardsCertificates').append(newInputAwardsCertificates);
            });

            $('#addInputPortfolio').click(function () {
                var indexPortfolio = $('#inputTemplatePortfolio .row').length+ $('#inputContainerPortfolio .row').length;
                var newPortfolioIndex = indexPortfolio;
                var newInputPortfolio = `
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <input type="text" class="form-control"
                                   placeholder="Portfolio adı"
                                   name="portfolio[${newPortfolioIndex}][portfolio_name]"/>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" placeholder="Portfolio linki"
                                   name="portfolio[${newPortfolioIndex}][portfolio_link]"/>
                        </div>
                    </div>`;
                $('#inputContainerPortfolio').append(newInputPortfolio);
            });
            $('#addInputSkill').click(function () {
                var indexSkill = $('#inputTemplateSkill .row').length+ $('#inputContainerSkill .row').length;
                var newSkillIndex = indexSkill;
                var newInputSkill = `
                                    <div class="row mb-4">
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control"
                                                   name="skill[${newSkillIndex}]"/>
                                        </div>
                                    </div>`;
                $('#inputContainerSkill').append(newInputSkill);
            });
            $('#addInputLangSkill').click(function () {
                var indexLangSkill = $('#inputTemplateLangSkill .row').length+ $('#inputContainerLangSkill .row').length;
                var newLangSkillIndex = indexLangSkill;
                var newInputLangSkill = `
                                     <div class="row mb-4">
                                        <div class="col-lg-4">
                                            <select class="form-control" name="lang[${newLangSkillIndex}][lang]">
                                                <option value="">Dilin adı</option>
                                                <option value="1">Azərbaycan dili</option>
                                                <option value="2">Rus dili</option>
                                                <option value="3">İngilis dili</option>
                                                <option value="4">Türk dili</option>
                                                <option value="5">Alman dili</option>
                                                <option value="6">Fransız dili</option>
                                                <option value="7">İspan dili</option>
                                                <option value="8">Çin dili (Mandarin)</option>
                                                <option value="9">Ərəb dili</option>
                                                <option value="10">Portuqal dili</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-control" name="lang[${newLangSkillIndex}][levels]">
                                                <option value="0">Səviyyəniz</option>
                                                <option value="1">Zəif</option>
                                                <option value="2">Orta</option>
                                                <option value="3">Yaxşı</option>
                                                <option value="4">Əla</option>
                                            </select>
                                        </div>
                                    </div>`;
                $('#inputContainerLangSkill').append(newInputLangSkill);
            });
        });
    </script>

    <script>
        jQuery(document).ready(function ($) {
            $('select[name=category_id]').on('change', function () {
                var id = $(this).find(":selected").attr('value');
                $.ajax({
                    url: '/user/sub-category/' + id + '',
                    type: 'GET',
                    dataType: 'json',

                }).done(function (data) {

                    var select = $('select[name=sub_category_id]');
                    select.empty();
                    $.each(data, function (key, value) {
                        select.append('<option value=' + value.id + '>' + decodeURIComponent(value.name['az']) + '</option>');
                    });
                })
            });
        });
    </script>

    <script src="{{ asset('user/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('user/assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/pages/ecommerce-select2.init.js') }}"></script>
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('summernote/editor_summernote.js') }}"></script>
@endsection
