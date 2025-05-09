<!-- FOOTER START -->
{{--<div class="modal fade twm-saved-jobs-view" id="messagesCon" aria-hidden="true" aria-labelledby="sign_up_popupLabel-3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon" style="text-align: center;"></div>
            </div>
            <div class="modal-body">
                <div class="modal-message" style="text-align: center;"></div>
            </div>
            <div class="modal-footer">
                <a href="{{ url()->current() }}" class="outline-primary">Bağla</a>
            </div>
        </div>
    </div>
</div>--}}
<div class="modal fade twm-saved-jobs-view" id="messagesCon" aria-hidden="true" aria-labelledby="sign_up_popupLabel-3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon" style="text-align: center;">
                    <!-- Burada ikon əlavə edə bilərsən, məsələn: -->
                    <i class="fas fa-bullhorn fs-1 text-primary"></i>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-message" style="text-align: center;">
                    <p class="fs-5 fw-semibold">
                        Ən son elanlar, ən yaxşı təkliflər və sürətli axtarış imkanları ilə tanış olun!
                    </p>
                    <div class="mt-4 d-flex justify-content-center align-items-center gap-2">
                        <a href="https://t.me/isverenaz" target="_blank" class="btn btn-outline-primary">
                            <i class="fab fa-telegram fa-lg"></i>
                            Abunə ol
                        </a>
                        <a href="@lang('web.instagram')" target="_blank" class="btn btn-outline-primary">
                            <i class="fab fa-instagram fa-lg"></i>
                            Takib et
                        </a>
                        <a href="@lang('web.linkedin')" target="_blank" class="btn btn-outline-primary">
                            <i class="fab fa-linkedin fa-lg"></i>
                            Takib et
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">Bağla</button>
            </div>
        </div>
    </div>
</div>



<footer class="footer-dark" style="background-image: url({{ asset("site/images/f-bg.jpg") }});">
    <div class="container">

        <!-- NEWS LETTER SECTION START -->
        <div class="ftr-nw-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="ftr-nw-title" style="text-align: center!important;">
                        Burada sizin bir reklamınız ola bilər.
                    </div>
                </div>
            </div>
        </div>
        <!-- NEWS LETTER SECTION END -->
        <!-- FOOTER BLOCKES START -->
        <div class="footer-top">
            <div class="row">

                <div class="col-lg-3 col-md-12">

                    <div class="widget widget_about">
                        <div class="logo-footer clearfix">
                            <a href="{{ route('web.home') }}">
                                <img src="{{ asset('site/images/logo/logo.png') }}" alt="">
                            </a>
                        </div>
                        <p>-İşverən və işçi bir arada.</p>
                        <ul class="ftr-list">
                            <li><p><span><i class="flaticon-email"></i></span>isveren.consulting@gmail.com</p></li>
                        </ul>
                    </div>

                </div>

                <div class="col-lg-9 col-md-12">
                    <div class="row">

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            {{--<div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">For Candidate</h3>
                                <ul>
                                    <li><a href="dashboard.html">User Dashboard</a></li>
                                    <li><a href="dash-resume-alert.html">Alert resume</a></li>
                                    <li><a href="candidate-grid.html">Candidates</a></li>
                                    <li><a href="blog-list.html">Blog List</a></li>
                                    <li><a href="blog-single.html">Blog single</a></li>
                                </ul>
                            </div>--}}
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                           {{-- <div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">For Employers</h3>
                                <ul>
                                    <li><a href="dash-post-job.html">Post Jobs</a></li>
                                    <li><a href="blog-grid.html">Blog Grid</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="job-list.html">Jobs Listing</a></li>
                                    <li><a href="job-detail.html">Jobs details</a></li>
                                </ul>
                            </div>--}}
                        </div>

                        <div class="col-lg-5 col-md-6 col-sm-6">
                            <div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">Tezliklə yeni xidmətlər burada!</h3>
                                {{--<ul>
                                    <li><a href="faq.html">FAQs</a></li>
                                    <li><a href="employer-detail.html">Employer detail</a></li>
                                    <li><a href="dash-my-profile.html">Profile</a></li>
                                    <li><a href="error-404.html">404 Page</a></li>
                                    <li><a href="pricing.html">Pricing</a></li>
                                </ul>--}}
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            {{--<div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">Quick Links</h3>
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="about-1.html">About us</a></li>
                                    <li><a href="dash-bookmark.html">Bookmark</a></li>
                                    <li><a href="job-grid.html">Jobs</a></li>
                                    <li><a href="employer-list.html">Employer</a></li>
                                </ul>
                            </div>--}}
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!-- FOOTER COPYRIGHT -->
        <div class="footer-bottom">

            <div class="footer-bottom-info">

                <div class="footer-copy-right">
                    <span class="copyrights-text"> © <?php echo date('Y') ?> Bütün hüquqlar qorunur <a href="https://www.instagram.com/anvarasgarov.dev" target="_blank" title="Anvar Asgarov" style="color: #ffffff!important;">By Anvar Asgarov</a></span>
                </div>
                <ul class="social-icons">
                    <li><a href="@lang('web.whatsapp')" class="fab fa-whatsapp"></a></li>
                    <li><a href="@lang('web.facebook')" class="fab fa-facebook"></a></li>
                    <li><a href="@lang('web.telegram')" class="fab fa-telegram"></a></li>
                    <li><a href="@lang('web.instagram')" class="fab fa-instagram"></a></li>
                    <li><a href="@lang('web.tiktok')" class="fab fa-tiktok"></a></li>
                    <li><a href="@lang('web.linkedin')" class="fab fa-linkedin"></a></li>
                </ul>

            </div>

        </div>

    </div>

</footer>
<!-- FOOTER END -->

<!-- BUTTON TOP START -->
<button class="scroltop"><span class="fa fa-angle-up  relative" id="btn-vibrate"></span></button>
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
@yield('web.js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Əsas səhifədəsə
        if (window.location.pathname === '/' /*&& !localStorage.getItem('visited')*/) {
            var modal = new bootstrap.Modal(document.getElementById('messagesCon'));
            modal.show();

            // localStorage.setItem('visited', 'true');
        }
    });
</script>

</body>
</html>
