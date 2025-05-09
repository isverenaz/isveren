<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/toastr.min.css') }}">
<div class="modal fade log-reg" id="exampleModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rounded overflow-hidden">
        <div class="modal-content">
            <div class="modal-body">
                <div class="register-login">
                    <h4 class="text-center border-b pb-2">@lang('web.login')</h4>
                    <div class="message"></div>
                    <form id="loginForm" action="{{ route('web.login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <input type="email" name="email" class="form-control" id="email" placeholder="@lang('web.email')">
                        </div>
                        <div class="form-group mb-2">
                            <input type="password" name="password" class="form-control" id="password" placeholder="@lang('web.password')">
                        </div>
                        <div class="comment-btn mb-2 pb-2 text-center border-b">
                            <button id="submit" class="job-btn">@lang('web.login')</button>
                        </div>
                    </form>

                   {{-- <div class="social-login text-center">
                        <a href="{{ url('auth/google') }}" class="btn btn-danger mb-2">
                            <i class="fab fa-google"></i> Google ilə Giriş
                        </a>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.interaction-button', function(e) {
            e.preventDefault();
            let button = $(this);

            console.log('ccc');

            // AJAX ile login olup olmadığını kontrol et
            $.ajax({
                type: 'GET',
                url: '{{ url("https://isveren.az/check-login") }}', // Login kontrolünü sağlayan route
                success: function(response) {
                    console.log(response.isLoggedIn);
                    if (response.isLoggedIn) {
                        // Eğer kullanıcı giriş yaptıysa, beğenme/diğer işlemi devam ettir
                        // Burada istediğiniz işlemi yapabilirsiniz.
                    } else {

                        let modal = $('#exampleModal1');

                        if (modal.length) {
                            console.log('Modal bulundu ve gösteriliyor');
                            modal.modal('show');
                        } else {
                            console.log('Modal bulunamadı!');
                            // Alternatif bir işlem gerçekleştirebilirsiniz. Örneğin, modal'ı dinamik olarak ekleyebilirsiniz.
                        }
                    }
                },
                error: function() {
                    // Hata oluşursa modalı yine göster
                    $('#exampleModal1').modal('show');
                }
            });
        });


        // Handle form submission with AJAX
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success == true)
                    {
                        $(".message").append('<div class="btn-success" style="text-align: center;">'+response.message+'</div>');
                        window.location = response.redirect;
                        $(".loginForm")[0].reset();

                        // $('#message').html(response.message);
                    }else{
                        console.log(response.error)
                        // $(".message").append('<div class="btn-danger">'+response.error+'</div>');
                        $(".message").empty(); // Clear existing errors
                        $.each(response.error, function(index, value) {
                            $(".message").append('<div class="btn-danger" style="text-align: center;">' + value + '</div>');
                        });
                    }

                    // Handle success (e.g., show a success message)
                },
                error: function(error) {
                    $(".message").append('<div class="btn-danger" style="text-align: center;">'+error+'</div>');
                    $(".loginForm")[0].reset();
                    // Handle errors (e.g., show an error message)
                }
            });
        });
    });
</script>
