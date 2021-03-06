<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') &nbsp;&nbsp;&nbsp;{{ option('web_name') }} &#8212; TaneCN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="shortcut icon" href="{{ asset('vendor/laravel-blog/logo.png') }}" type="image/x-icon">
    <!-- elfinder -->
    <link rel="stylesheet" href="{{ asset('vendor/laravel-blog/jquery-ui/themes/base/minified/jquery-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/laravel-blog/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/laravel-blog/elfinder/css/theme.css') }}">
    <!-- elfinder -->

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/font-awesome/css/font-awesome.min.css') }}">

    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/select2/css/select2.min.css') }}">

    <!-- nestable -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/nestable/nestable.css') }}">

    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/admin-lte/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/admin-lte/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/nprogress/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/jquery-confirm/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/iCheck/skins/all.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/bootstrap-switch/css/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/bootstrap-duallistbox/css/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/bootstrap3-editable/css/bootstrap-editable.css') }}">

{!! Admin::asset()->css() !!}

<!-- app -->
    <link rel="stylesheet" href="{{ asset('/vendor/laravel-blog/admin/app.min.css') }}">

    <!-- jQuery 3 -->
    <script src="{{ asset('/vendor/laravel-blog/jquery/jquery.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-black sidebar-mini fixed">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>T</b>c</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Tane</b>CN</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="javascript:;" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ Auth::user()->avatar }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ Auth::user()->username }}
                                    <small>{{ Auth::user()->name }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.users.edit', Auth::id()) }}" class="btn btn-default btn-flat">{{ trans('admin.edit_profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ option('web_url') }}"><i class="fa fa-home"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                {!! Admin::menu()->render() !!}
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="pjax-container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('title')
                <small>@yield('description')</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
                @yield('breadcrumbs')
                <li class="active">@yield('title')</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content box-body">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Made by The <a href="http://www.tanecn.com" target="_blank">TaneCN</a>.</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('/vendor/laravel-blog/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/nprogress/nprogress.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('/vendor/laravel-blog/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/vendor/laravel-blog/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/vendor/laravel-blog/admin-lte/js/adminlte.min.js') }}"></script>

<script src="{{ asset('/vendor/laravel-blog/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/nestable/nestable.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/jquery-pjax/pjax.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/sortable/Sortable.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/imsky-holder/holder.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/bootstrap-duallistbox/js/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('/vendor/laravel-blog/tinymce/tinymce.min.js') }}"></script>
@if(config('app.locale') != 'en')
    <script src="{{ asset('/vendor/laravel-blog/tinymce/langs/'. config('app.locale') .'.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-blog/select2/js/i18n/'. config('app.locale') .'.js') }}"></script>
@endif

<script src="{{ asset('vendor/laravel-blog/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>

<!-- elfinder -->
<script src="{{ asset('vendor/laravel-blog/jquery-ui/ui/minified/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-blog/elfinder/js/elfinder.min.js') }}"></script>
<!-- elfinder -->

{{--<script src="{{ asset('vendor/laravel-blog/transliteration-1.6.2/lib/browser/transliteration.min.js') }}"></script>--}}

<script src="{{ asset('/vendor/laravel-blog/admin/app.min.js') }}"></script>

{!! Admin::asset()->js() !!}

<script>
    var timeout_load = '{{ trans('admin.timeout_load') }}';
    var imageJconfirm;
    var elfinder_container;
    function showImageSelector(url) {
        elfinder_container = $.dialog({
            title: "{{ trans('admin.select_image') }}",
            content:"URL:/admin/elfinder/popup/" + url,
            animation: 'scale',
            closeAnimation: 'scale',
            backgroundDismiss: true,
            //theme: 'supervan',
            columnClass:'xlarge',
            /*onContentReady: function () {
                var self = this;
            },*/
        });
    }

    function listSelectedRows() {
        var selected = [];
        $('.grid-row-checkbox:checked').each(function () {
            selected.push($(this).data('id'));
        });
        if (selected.length < 1) {
            $.alert({
                title:false,
                type: 'red',
                content: "{{ trans('admin.please_select_data') }}",
                buttons:{
                    yes:{
                        text:"{{ trans('admin.ok') }}"
                    }
                }
            });
            /*$.dialog({
                title: false,
                content: '{{ trans('admin.please_select_data') }}',
            });*/
            return false;
        }
        return selected;
    };

    function ajaxDelete(url, id, type){

        if(type == 'trash'){
            var message = "{{ trans('admin.trash_message') }}"
        }else{
            var message = "{{ trans('admin.delete_message') }}";
        }

        $.confirm({
            title: '{{ trans('admin.delete_confirm') }}',
            content: message,
            autoClose: 'cancelAction|6000',
            buttons: {
                deleteAction: {
                    text: "{{ trans('admin.delete') }}",
                    action: function () {
                        $.ajax({
                            method: 'post',
                            url: url+'/' + id,
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                $.pjax.reload('#pjax-container');
                                toastr.success(data.message);
                            }
                        });
                    }
                },
                cancelAction: {
                    text: '{{ trans('admin.cancel') }}'
                }
            }
        });
    }

    $(function () {
        toastr.clear();
        @if (session('toastr_success'))
        toastr.success('{{ session('toastr_success') }}')
        @endisset

        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}', '{{ trans('admin.failed') }}')
        @endforeach
    });
</script>
</body>
</html>