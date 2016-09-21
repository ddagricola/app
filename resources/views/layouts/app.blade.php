<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>app.ddagricola.gt</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
          -->
          <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue-light.min.css")}}" rel="stylesheet" type="text/css" />

          <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/datepicker/datepicker3.css') }}">
        <style type="text/css">
        .select2-container--default .select2-selection--single {
            border-radius: 0px; 
            padding: 5px
        }
        .visitado{
            border-bottom: 4px solid red;
        }
        </style>
        <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
    </head>
    <body class="skin-blue-light">
        <div class="wrapper">
            @include('layouts.header')
            @include('layouts.sidebar')
                <div class="content-wrapper">
                    @yield('content')
                </div>
            @include('layouts.footer')
        </div><!-- ./wrapper -->
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
        <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/fastclick/fastclick.js') }}"></script>
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.11/sorting/numeric-comma.js"></script>
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset ('/bower_components/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
        <!-- Smartsupp Live Chat script -->
        <script type="text/javascript">
        /*$(".js_menu").on('click', function(e){
            $(this).find("i").removeClass("fa-folder-o");
        });*/
          /*$('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
          });*/
        /*var _smartsupp = _smartsupp || {};
        _smartsupp.key = '4207532b3e35c3150cebe8c8caf5183a5c30a02c';
        window.smartsupp||(function(d) {
            var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
            s=d.getElementsByTagName('script')[0];c=d.createElement('script');
            c.type='text/javascript';c.charset='utf-8';c.async=true;
            c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
        })(document);*/
        </script>
    </body>
</html>