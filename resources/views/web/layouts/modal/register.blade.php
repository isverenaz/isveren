<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/toastr.min.css') }}">
<div class="modal fade log-reg" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog rounded overflow-hidden">
        <div class="modal-content">
            <div class="modal-body">
                <div class="register-login">
                    <h4 class="text-center border-b pb-2">@lang('web.register')</h4>
                    <div class="message"></div>
                    </br>

                    <!-- Tabs Nav -->

                    <form id="registrationForm" action="{{ route('web.register') }}" method="POST">
                        @csrf
                    <ul class="nav nav-tabs justify-content-center mb-3" id="roleTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-2" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button" role="tab" aria-controls="company" aria-selected="false">
                                Şirkət kimi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  px-4 py-2" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="true">
                                İstifadəçi kimi
                            </button>
                        </li>
                    </ul>
                    <!-- Tabs Content -->
                    <div class="tab-content mt-3" id="roleTabsContent">
                        <!-- İş axtaran -->
                        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                                <input type="hidden" name="role" value="users">
                                <div class="form-group mb-2">
                                    <input type="text" name="name_surname" class="form-control" placeholder="@lang('web.full_name')">
                                </div>
                                <div class="form-group mb-2">
                                    <input type="email" name="email" class="form-control" placeholder="@lang('web.email')">
                                </div>
                                <div class="form-group mb-2">
                                    <input type="text" name="phone" class="form-control" placeholder="@lang('web.phone')">
                                </div>
                                <div class="form-group mb-2">
                                    <input type="password" name="password" class="form-control" placeholder="@lang('web.password')">
                                </div>
                                <div class="form-group mb-2 d-flex">
                                    <input type="checkbox" name="accept" class="custom-control-input" id="userAccept" value="1">
                                    <label class="custom-control-label mb-0 ms-1 lh-1" for="userAccept">@lang('web.accept')</label>
                                </div>
                                <div class="comment-btn mb-2 pb-2 text-center border-b">
                                    <button type="submit" class="job-btn">@lang('web.register')</button>
                                </div>
                                <div class="social-login text-center">
                                    <a href="{{ url('auth/google') }}" class="btn btn-danger mb-2">
                                        <i class="fab fa-google"></i> Google ilə Giriş
                                    </a>
                                </div>
                        </div>
                        <!-- Şirkət -->
                        <div class="tab-pane fade  show active " id="company" role="tabpanel" aria-labelledby="company-tab">
                                <input type="hidden" name="role" value="company">
                                <div class="form-group mb-2">
                                    <input type="text" name="name_surname" class="form-control" placeholder="@lang('web.full_name')">
                                </div>
                                <div class="form-group mb-2">
                                    <input type="email" name="email" class="form-control" placeholder="@lang('web.email')">
                                </div>
                                <div class="form-group mb-2">
                                    <input type="text" name="phone" class="form-control" placeholder="@lang('web.phone')">
                                </div>
                                <div class="form-group mb-2">
                                    <input type="password" name="password" class="form-control" placeholder="@lang('web.password')">
                                </div>
                                <div class="form-group mb-2 d-flex">
                                    <input type="checkbox" name="accept" class="custom-control-input" id="companyAccept" value="1">
                                    <label class="custom-control-label mb-0 ms-1 lh-1" for="companyAccept">@lang('web.accept')</label>
                                </div>
                                <div class="comment-btn mb-2 pb-2 text-center border-b">
                                    <button type="submit" class="job-btn">@lang('web.register')</button>
                                </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{{--<script src="https://www.google.com/recaptcha/api.js" async defer></script>--}}
<script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#registrationForm').submit(function(e) {
            e.preventDefault();

            // Düyməni deaktiv et
            let $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Gözləyin...');

            let timer = setInterval(function() {
                let timeLeft = parseInt($submitButton.data('time-left')) || 5; // Saniyə sayğacı (5 saniyə nümunə)
                if (timeLeft > 0) {
                    $submitButton.text(`Gözləyin... (${timeLeft})`);
                    $submitButton.data('time-left', timeLeft - 1);
                } else {
                    clearInterval(timer);
                }
            }, 1000);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    clearInterval(timer); // Saniyə sayğacı dayandır
                    if (response.success == true) {
                        $(".message").append('<div class="btn-success" style="text-align: center;">' + response.message + '</div>');
                        window.location = response.redirect;
                        $(".registrationForm")[0].reset();
                    } else {
                        $(".message").empty(); // Mövcud səhvləri təmizlə
                        $.each(response.error, function(index, value) {
                            $(".message").append('<div class="btn-danger" style="text-align: center;">' + value + '</div>');
                        });
                    }
                    // Düyməni yenidən aktiv et
                    $submitButton.prop('disabled', false).text('@lang("web.register")');
                    $submitButton.removeData('time-left');
                },
                error: function(error) {
                    clearInterval(timer); // Saniyə sayğacı dayandır
                    $(".message").append('<div class="btn-danger" style="text-align: center;">' + error.responseText + '</div>');
                    $(".registrationForm")[0].reset();
                    // Düyməni yenidən aktiv et
                    $submitButton.prop('disabled', false).text('@lang("web.register")');
                    $submitButton.removeData('time-left');
                }
            });
        });
    });

</script>
{{--<script>
    $(document).ready(function() {
        // Handle form submission with AJAX
        $('#registrationForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success == true) {
                        $(".message").append('<div class="btn-success" style="text-align: center;">' + response.message + '</div>');
                        window.location = response.redirect;
                        $(".registrationForm")[0].reset();
                    } else {
                        $(".message").empty(); // Clear existing errors
                        $.each(response.error, function(index, value) {
                            $(".message").append('<div class="btn-danger" style="text-align: center;">' + value + '</div>');
                        });
                    }
                },
                error: function(error) {
                    $(".message").append('<div class="btn-danger" style="text-align: center;">' + error.responseText + '</div>');
                    $(".registrationForm")[0].reset();
                }
            });
        });
    });
</script>--}}
