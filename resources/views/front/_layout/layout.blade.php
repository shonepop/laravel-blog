<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">

        <!-- SEO SECTION -->
        <!-- Title  -->
        <title>Blog | @yield("seo_title", __("Articles on technologies, business, personal growth, sales..."))</title>
        <meta name="description" content="@yield('seo_description', __('Stay up-to-date with information on the latest technologies, sales methods, personal growth and much more...'))">

        <!-- OpenGraph META -->
        <meta property="og:site_name" content="{{config('app.name')}}">
        <meta property="og:type" content="@yield('seo_og_type', __('article'))">
        <meta property="og:title" content="@yield('seo_title', __('Articles on technologies, business, personal growth, sales...'))">
        <meta property="og:description" content="@yield('seo_description', __('Stay up-to-date with information on the latest technologies, sales methods, personal growth and much more...'))">
        <meta property="og:image" content="@yield('seo_image', url('/themes/front/img/favicon.ico'))">
        <meta property="og:url" content="{{url()->current()}}">

        <!-- TWITTER META -->
        <meta name="twitter:card" content="{{config('app.name')}}">
        <meta name="twitter:title" content="@yield('seo_title', __('Articles on technologies, business, personal growth, sales...'))">
        <meta name="twitter:description" content="@yield('seo_description', __('Stay up-to-date with information on the latest technologies, sales methods, personal growth and much more...'))">
        <meta name="twitter:image" content="@yield('seo_image', url('/themes/front/img/favicon.ico'))">

        @yield("head_meta")

        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/font-awesome/css/font-awesome.min.css')}}">
        <!-- Custom icon font-->
        <link rel="stylesheet" href="{{url('/themes/front/css/fontastic.css')}}">
        <!-- Google fonts - Open Sans-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
        <!-- Fancybox-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.css')}}">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="{{url('/themes/front/css/style.default.css')}}" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="{{url('/themes/front/css/custom.css')}}">
        <!-- Favicon-->
        <link rel="shortcut icon" href="{{url('/themes/front/img/favicon.ico')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/toastr/toastr.min.css')}}">


        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        @yield("recaptcha")
        @stack("head_css")
        
    </head>
    <body>
        <header class="header">
            <!-- Main Navbar - Logo, Home, Blog, Contact, Search -->
            @include("front._layout.navigation")
        </header>

        @yield("content")

        <!-- Page Footer-->
        @include("front._layout.footer")

        <!-- JavaScript files-->
        <script src="{{url('/themes/front/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/popper.js/umd/popper.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
        <script src="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.js')}}"></script>
        <script src="{{url('/themes/front/js/front.js')}}"></script>
        <!-- Toastr -->
        <script src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}"></script>
        
        <script>
            let systemMessage = "{{session()->pull('system_message')}}";
            if (systemMessage !== "") {
                 toastr.success(systemMessage);
            }
            let systemError = "{{session()->pull('system_error')}}";
            if (systemError !== "") {
                 toastr.error(systemError);
            }
        </script>
        @stack("footer_javascript")

    </body>
</html>