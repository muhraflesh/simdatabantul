<!DOCTYPE html>
<html class="loading" lang="{{ app()->getLocale() }}" data-textdirection="ltr">
    <!-- BEGIN: Head-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
        <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
        <meta name="author" content="ThemeSelect">
        <title>{{ config('app.name', 'Larakuy') }} | Authentication</title>
        <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon/favicon-32x32.png') }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- BEGIN: VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/vendors.min.css') }}">
        <!-- END: VENDOR CSS-->
        <!-- BEGIN: Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/vertical-modern-menu-template/materialize.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/vertical-modern-menu-template/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/login.css') }}">
        <!-- END: Page Level CSS-->
        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom/custom.css') }}">
        <!-- END: Custom CSS-->
    </head>

    <!-- END: Head-->
    <body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 1-column login-bg  blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column" style="background-color: #1c6786;">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- BEGIN VENDOR JS-->
        <script src="{{ asset('js/vendors.min.js') }}" type="text/javascript"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN THEME  JS-->
        <script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/custom/custom-script.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/scripts/ui-alerts.js') }}" type="text/javascript"></script>
        <!-- END THEME  JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <!-- END PAGE LEVEL JS-->

    </body>
</html>