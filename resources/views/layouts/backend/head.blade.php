    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="author" content="ThemeSelect">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Larakuy') }} Administrator</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon/favicon-32x32.png') }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- BEGIN: VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/vendors.min.css') }}">
        <!-- END: VENDOR CSS-->
        <!-- BEGIN: Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/vertical-modern-menu-template/materialize.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/vertical-modern-menu-template/style.css') }}">
        <!-- END: Page Level CSS-->
        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom/custom.css') }}">
        <!-- END: Custom CSS-->
        
        <!-- Google Font -->
        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
        @stack('style')
    </head>