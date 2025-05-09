@extends('admin.layouts.app')

@section('admin.css')
    <style>
        body {
            background-color: #fafafa;
        }

        .container {
            margin: 150px auto;
        }

        input[lang="ru"] {
            display: none
        }

        label[lang="ru"] {
            display: none
        }
    </style>
@endsection
@section('admin.content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
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
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title-desc">User Edit</h4>

                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @if ($errors->any())
                                    <div id="error-message" class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mb-3 row">
                                    <div class="language-container" style="display: flex;">
                                        <div class="col-md-10">
                                            <label for="name" class="form-label">Name</label>
                                            <input class="form-control" type="text" value="{{ $user['name'] }}"
                                                name="name" value="" id="name">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <div class="language-container" style="display: flex;">
                                        <div class="col-md-10">
                                            <label for="surname" class="form-label">Surname</label>
                                            <input class="form-control" type="text" value="{{ $user['surname'] }}"
                                                name="surname" value="" id="surname">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <div class="language-container" style="display: flex;">
                                        <div class="col-md-10">
                                            <label for="email" class="form-label">Email</label>
                                            <input class="form-control" type="text" value="{{ $user['email'] }}"
                                                name="email" value="" id="email">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <div class="col-md-10">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" type="password" name="password" value=""
                                            id="password">
                                    </div>
                                </div>
                                <div class="mt-3 row">
                                    <div class="col-md-10">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="confirm_password"
                                            value="" id="confirm_password">
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label>Permission</label>
                                    <div class="col-md-10">
                                        @foreach (\App\Models\Permission::all() as $permission)
                                        <input type="checkbox" id="permission" name="permission[]"
                                        value="{{ $permission->slug }}" {{ $user->permissions->contains('id', $permission->id) ? 'checked' : '' }}>

                                            <label for="vehicle1" class="form-label">
                                                {{ $permission->name }}</label><br>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="mt-3 row">
                                    <label>Role</label>
                                    <div class="col-md-10">
                                        @foreach (\App\Models\Role::all() as $role)
                                        <input type="checkbox" id="vehicle1" name="role[]"
                                        value="{{ $role->slug }}" {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                                            <label for="vehicle1" class="form-label">
                                                {{ $role->name }}</label><br>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="mb-3 row  mt-4">
                                    <div class="col-md-" dir="ltr">
                                        <button class="btn btn-success" type="submit">Submit</button>
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
        var selectedLanguage = 'az';

        function switchLanguage(lang) {
            selectedLanguage = lang;
            updateElementVisibility();
        }

        function updateElementVisibility() {
            $('.language-container').each(function() {
                if ($(this).attr("lang") === selectedLanguage) {
                    $(this).css("display", "block");
                } else {
                    $(this).css("display", "none");
                }
            });
        }

        function getInputAndLabelValue() {
            var inputId = "input-" + selectedLanguage;
            var inputValue = $("#" + inputId).val();

            var labelFor = $("label[for='" + inputId + "']");
            var labelValue = labelFor.text();

            alert("Input Value: " + inputValue + "\nLabel Value: " + labelValue);
        }
    </script>

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
