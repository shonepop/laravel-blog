<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield("seo_title") | Admin Area</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/jqvmap/jqvmap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('/themes/admin/dist/css/adminlte.min.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/daterangepicker/daterangepicker.css')}}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/summernote/summernote-bs4.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/toastr/toastr.min.css')}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        @stack("head_links")

    </head>
    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper">

            @include("admin._layout.partials.top_menu")
            @include("admin._layout.partials.sidebar")


            <div class="content-wrapper">
                @yield("content")
            </div>


        </div>
        <!-- ./wrapper -->

        @include("admin._layout.partials.footer")

        <!-- jQuery -->
        <script src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
$.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{url('/themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{url('/themes/admin/plugins/chart.js/Chart.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{url('/themes/admin/plugins/sparklines/sparkline.js')}}"></script>
        <!-- JQVMap -->
        <script src="{{url('/themes/admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{url('/themes/admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{url('/themes/admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{url('/themes/admin/plugins/moment/moment.min.js')}}"></script>
        <script src="{{url('/themes/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{url('/themes/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <!-- Summernote -->
        <script src="{{url('/themes/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{url('/themes/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}"></script>
        <!-- DataTables -->
        <script src="{{url('/themes/admin/plugins/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{url('/themes/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
        <!-- Select2 -->
        <script src="{{url('/themes/admin/plugins/select2/js/select2.full.min.js')}}"></script>
        <!-- jquery-validation -->
        <script src="{{url('/themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
        <script src="{{url('/themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{url('/themes/admin/dist/js/adminlte.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{url('/themes/admin/dist/js/pages/dashboard.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{url('/themes/admin/dist/js/demo.js')}}"></script>

        <script>
let systemMessage = '{{session()->pull("system_message")}}';
if (systemMessage !== "") {
    toastr.success(systemMessage);
}
let systemError = '{{session()->pull("system_error")}}';
if (systemError !== "") {
    toastr.error(systemError);
}
        </script>

        @stack("footer_javascript")
    </body>
</html>

