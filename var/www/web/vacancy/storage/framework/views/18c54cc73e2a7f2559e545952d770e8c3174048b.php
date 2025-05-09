
    <style>
        @media (max-width: 600px) {
            .register {
                display: block !important; /* Change to the appropriate display value for your design */
            }
            .access {
                display: block !important; /* Change to the appropriate display value for your design */
            }

            .logo-img {
                width: 85%;
            }
        }
    </style>
    <header class="main_header_area">
        <div class="header-content py-1 bg-theme">
            <div class="container d-flex align-items-center justify-content-between">
                <div class="links">
                    <ul>
                        <li>
                            <?php
                                $dateString = \Carbon\Carbon::now();
                                $date = new DateTime($dateString);
                                $months = [
                                    1 => "Yanvar",
                                    2 => "Fevral",
                                    3 => "Mart",
                                    4 => "Aprel",
                                    5 => "May",
                                    6 => "June",
                                    7 => "İyul",
                                    8 => "Avqust",
                                    9 => "Sentyabr",
                                    10 => "Oktyabr",
                                    11 => "Noyabr",
                                    12 => "Dekabr"
                                ];
                                $formattedDate = $date->format('d ') . $months[(int)$date->format('m')] . $date->format(' Y');
                            ?>

                            <a href="#" class="white">
                                <i class="icon-calendar white"></i> <?php echo e($formattedDate); ?>

                            </a>
                        </li>
                        <li><a href="#" class="white"><i class="icon-location-pin white"></i><?php echo app('translator')->get('web.country'); ?></a></li>
                    </ul>
                </div>
                <div class="links float-right">
                    <ul>
                        <li><a href="<?php echo app('translator')->get('web.whatsapp'); ?>" class="white" title="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo app('translator')->get('web.facebook'); ?>" class="white" title="facebook"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo app('translator')->get('web.telegram'); ?>" class="white" title="telegram"><i class="fab fa-telegram" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo app('translator')->get('web.instagram'); ?>" class="white" title="instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo app('translator')->get('web.tiktok'); ?>" class="white" title="Tiktok">t</a></li>
                        <li><a href="<?php echo app('translator')->get('web.linkedin'); ?>" class="white" title="linkedin"><i class="fab fa-linkedin " aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="header_menu" id="header_menu">
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-flex d-flex align-items-center justify-content-between w-100 pb-3 pt-3">
                        <div class="navbar-header" style="max-width: 173px">
                            <a class="navbar-brand" href="<?php echo e(route('web.home')); ?>">
                            <a class="navbar-brand"  href="<?php echo e(route('web.home')); ?>">
                                <img src="<?php echo e(asset('web/assets/images/logo.png')); ?>" class="logo-img" alt="image">
                            </a>
                        </div>

                        <div class="navbar-collapse1 d-flex align-items-center" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav" id="responsive-menu">
                                <?php if(!empty(auth()->guard('web')->user()->id)): ?>
                                <li class="register" style="display: none;"><a href="<?php echo e(route('web.user.jobs.list')); ?>"
                                        >Vakansiyalarım</a>  </li>
                                <li class="access"  style="display: none;"><a href="<?php echo e(route('web.user.settings',auth()->guard('web')->user()->id)); ?>"
                                 >Şəxsi məlumatlar</a>  </li>

                                    <?php else: ?>

                                <li class="register" style="display: none;"><a href="" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Qeydiyyat</a>  </li>
                                <li class="access" style="display: none;"><a href="" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal1">Giriş et</a>  </li>
                                    <?php endif; ?>
                                <li><a href="<?php echo e(route('web.about')); ?>"><?php echo app('translator')->get('web.about_us'); ?></a></li>
                                <li><a href="<?php echo e(route('web.home')); ?>"><?php echo app('translator')->get('web.jobs'); ?></a></li>
                                <li><a href="<?php echo e(route('web.companies')); ?>"><?php echo app('translator')->get('web.companies'); ?></a></li>

                                <li><a href="<?php echo e(route('web.contact')); ?>"><?php echo app('translator')->get('web.contact_us'); ?></a></li>
                            </ul>
                        </div>
                        <div class="register-login d-flex align-items-center">
                            <?php if(!empty(auth()->guard('web')->user()->id)): ?>
                                <a  href="<?php echo e(route('web.user.jobs.list')); ?>" class="job-top-item d-flex align-items-center border-b">
                                    <figure class="me-3 mb-0">
                                        <img alt="" src="<?php echo e(asset('user/user.png')); ?>" style="width: 30px; height: 31px; border-radius: 50%; !important;">
                                    </figure>
                                    <div class="job-info-creator">
                                        <h6 class="mb-0"><?php echo e(auth()->guard('web')->user()->name); ?> <?php echo e(auth()->guard('web')->user()->surname); ?></h6>

                                    </div>
                                </a>
                                <a href="<?php echo e(route('web.user.follower')); ?>" class="wishlist"></a>
                            <?php else: ?>
                                <a href="#" class="me-4" data-bs-toggle="modal"
                                   data-bs-target="#exampleModal"><u><?php echo app('translator')->get('web.register'); ?></u></a>
                                <a href="#" class="job-btn job-login btn1 white" data-bs-toggle="modal"
                                   data-bs-target="#exampleModal1"><?php echo app('translator')->get('web.login'); ?></a>
                            <?php endif; ?>

                        </div>
                        <div id="slicknav-mobile"></div>
                    </div>
                </div>
            </nav>
        </div>

    </header>

    <style>
        .wishlist {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 2px;
            margin-left: 25px;
            border-radius: 12px;
            color: #061e40;
            width: 40px;
            height: 40px;
            margin-right: 9px;
            background-color: #f3f6f9;
        }
        .wishlist {
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 8px;
            background-image: url("<?php echo e(asset('web/assets/images/heart-dislike.png')); ?>");

            background-size: 18px;
            opacity: 1;
        }
    </style>
    <?php /**PATH C:\Users\Emil\Desktop\vacancy\resources\views/components/web/header.blade.php ENDPATH**/ ?>
