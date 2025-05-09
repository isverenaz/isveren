<style>
    .file-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin: 20px auto;
        position: relative;
    }

    .custom-file-upload {
        background-color: #4caf50;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
    }

    .custom-file-upload:hover {
        background-color: #388e3c;
    }

    #resume {
        display: none; /* Standart fayl inputu gizlədilir */
    }

    #resume-name {
        margin-top: 10px;
        font-size: 12px;
        color: #fffdfd;
        word-wrap: break-word;
        text-align: center;
    }
</style>
<div class="modal fade log-reg" id="job-contact" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rounded overflow-hidden">
        <div class="modal-content">
            <div class="modal-body">
                <div class="register-login">
                    <h4 class="text-center border-b pb-2">{{ json_decode($job, true)['title']['az'] }} - müraciət et</h4>
                    <div class="message"></div>
                    <form id="jobContactForm" action="{{ route('web.jobContact') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $job->company['id'] ?? null }}">
                        <input type="hidden" name="job_id" value="{{ $job['id'] }}">
                        <input type="hidden" name="user_id" value="{{  auth()->guard('web')->user()->id ?? null }}">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-2">
                                    <label>@lang('web.full_name')</label>
                                    <input type="text" id="fullname" name="fullname">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-2">
                                    <label>@lang('web.phone')</label>
                                    <input type="text" id="phone" name="phone">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-2">
                                    <label>@lang('web.email')</label>
                                    <input type="email" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-2 file-upload">
                                    <label for="resume" class="custom-file-upload">
                                        📁<span id="resume-name"> Cv əlavə et</span>
                                    </label>
                                    <input id="resume" name="resume" type="file" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    <label>Motivasiya mektubu</label>
                                    <textarea name="messages" id="messages"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="comment-btn mb-2 pb-2 text-center border-b">
                            <button id="submit" class="job-btn">Göndər</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        const fileInput = document.getElementById('resume');
        const fileName = document.getElementById('resume-name');

        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = 'Fayl seçilməyib';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#jobContactForm').submit(function(e) {
                e.preventDefault();

                // FormData ilə form məlumatlarını topla
                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false, // FormData üçün lazımdır
                    contentType: false, // FormData üçün lazımdır
                    success: function(response) {
                        if (response.success == true) {
                            $(".message").append('<div class="btn-success" style="text-align: center;">'+response.message+'</div>');
                            window.location = window.location.redirect;
                            $("#jobContactForm")[0].reset();
                        } else {
                            $(".message").empty(); // Mövcud xətaları təmizlə
                            $.each(response.error, function(index, value) {
                                $(".message").append('<div class="btn-danger" style="text-align: center;">' + value + '</div>');
                            });
                        }
                    },
                    error: function(error) {
                        $(".message").append('<div class="btn-danger" style="text-align: center;">Xəta baş verdi: '+error.responseJSON.message+'</div>');
                    }
                });
            });
        });
    </script>
</div>
