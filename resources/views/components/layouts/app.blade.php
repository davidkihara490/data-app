<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="dark" data-topbar-color="light">


<!-- Mirrored from myrathemes.com/drezoc/layouts/pages-login by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 12 Jan 2025 07:05:46 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Data Management') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name', 'Data Management') }}" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{  asset('assets/css/style.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{  asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{  asset('assets/js/config.js') }}"></script>
</head>

<body>
    <div>
        <div class="container">
            {{ $slot }}
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- App js -->
    <script src="{{  asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{  asset('assets/js/app.js') }}"></script>
</body>
</html>