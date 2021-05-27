<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('websetting.name')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @include('adminlte::plugins', ['type' => 'css'])

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @yield('adminlte_css')
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('js/trixV1.2.0/trix.css')}}">
    <script type="text/javascript" src={{asset('js/trixV1.2.0/trix.core.js')}}></script>
    {{-- <script type="text/javascript" src={{asset('js/trixV1.2.0/trix.min.js')}}></script> --}}
    <script type="text/javascript" src="{{asset('js/trix.js?v='.date('is'))}}"></script>


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{{asset('bower_components/select2/dist/js/select2.min.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/select2/dist/css/select2.min.css')}}">

    <style type="text/css">
        .select2-selection__choice{
            color: #222!important;
        }
    </style>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('body_class')">

@yield('body')

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/app.js?v='.date('is'))}}"></script>


@include('sweetalert::alert')

@include('adminlte::plugins', ['type' => 'js'])

@yield('adminlte_js')

<style type="text/css">
    table th,table td{
        font-size: 10px;
    }
</style>

</body>
</html>
