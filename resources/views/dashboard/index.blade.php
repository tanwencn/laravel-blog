@extends('admin::layouts.app')

@section('title', trans('admin.dashboard'))

@section('description', trans('admin.control_panel'))

@section('content')
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        {{ Widget::group('admin_dashboard_left')->display() }}
    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-6 connectedSortable">
        {{ Widget::group('admin_dashboard_right')->display() }}
    </section>
    <!-- right col -->
</div>
<!-- /.row (main row) -->
@endsection