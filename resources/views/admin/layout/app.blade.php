<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
        rel="stylesheet">

    {{-- Custom Styles --}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @include('admin.layout.header')
        @include('admin.layout.sidebar')

        <div class="content-wrapper">
            {{-- ========================================== --}}
            {{-- Content Header --}}
            {{-- ========================================== --}}
            <section class="content-header">
                <h1>
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <ol class="breadcrumb">
                    {{-- <li>
                        @include ('admin.snippets.search_modal')
                    </li> --}}
                    
                    @yield('admin_header')
                </ol>
            </section>

            {{-- ========================================== --}}
            {{-- Admin Sections --}}
            {{-- ========================================== --}}
            <section class="content container-fluid">

                {{-- ========================================== --}}
                {{-- Admin Sections --}}
                {{-- ========================================== --}}
                @include('admin.layout.message')
                @yield('admin')

            </section>
        </div>

        {{-- ========================================== --}}
        {{-- SideBar Controls--}}
        {{-- ========================================== --}}
        {{-- @include('admin.layout.sidebar_control') --}}

    </div>
    
    <script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>


    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
