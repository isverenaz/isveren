<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>isveren.az</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
</head>

<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7fc; color: #495057; margin: 0;">
<div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 7px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ asset('web/assets/images/logo.png') }}" alt="Logo" style="max-width: 150px;"/>
    </div>

    <table style="width: 100%; border-spacing: 0;">
        <tr>
            <td style="background-color: #556ee6; color: white; padding: 20px; text-align: center; border-radius: 7px 7px 0 0;">
                {{ !empty($data['title'])? $data['title']: null }}
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; background-color: #fff; border-radius: 0 0 7px 7px;">
                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                    {{ !empty($data['subject'])? $data['subject']: null }}
                </p>
                <p style="font-size: 14px; line-height: 1.5; margin: 0 0 20px;">
                    {{ !empty($data['email'])? "E-poçt: ".$data['email']: null }}
                </p>
                @if(!empty($data['password']))
                <p style="font-size: 14px; line-height: 1.5; margin: 0 0 20px;">
                    {{ !empty($data['password'])? "Şifrə: ".$data['password']: null }}
                </p>
                @endif
                @if(!empty($data['phone']))
                <p style="font-size: 14px; line-height: 1.5; margin: 0 0 20px;">
                    {{ !empty($data['phone'])? "Əlaqə nömrəsi: ".$data['phone']: null }}
                </p>
                @endif
                @if(!empty($data['url']))
                <!-- Call to Action Button -->
                <div style="text-align: center; margin: 20px 0;">
                    <a href="{{ !empty($data['url'])? $data['url']: null }}" style="background-color: #34c38f; color: white; padding: 12px 24px; text-decoration: none; font-size: 16px; border-radius: 5px; display: inline-block;">
                        Daxil ol
                    </a>
                </div>
                @endif
                @if(!empty($data['resume']))
                <!-- Call to Action Button -->
                <div style="text-align: center; margin: 20px 0;">
                    <a href="{{ asset("uploads/job-contact/".$data['resume']) }}" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #34c38f; margin: 0; border-color: #34c38f; border-style: solid; border-width: 8px 16px;" download="{{ $data['resume'] }}">Müraciətə bax</a>
                </div>
                @endif

                <p style="text-align: center; font-size: 14px; line-height: 1.5; margin: 0 0 20px;">
                    Bizi seçdiyiniz üçün təşəkkür edirik!
                </p>

                <footer style="text-align: center; font-size: 14px; color: #888; margin-top: 40px;">
                    © <?= date('Y') ?> isveren.az
                </footer>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
