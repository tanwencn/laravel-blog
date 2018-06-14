@extends('admin::layouts.app')

@section('title', trans('admin.ad_list'))

@section('content')
<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm">{{ trans('admin.batch') }}</button>
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)" class="grid-batch-delete" data-url="{{ request()->getPathInfo() }}">{{ trans('admin.delete') }}</a></li>
                    </ul>
                </div>

                <div class="btn-group">
                    <a class="btn btn-sm btn-success" href="{{ Admin::action('create') }}"><i
                                class="fa fa-plus f-s-12"></i> {{ trans('admin.add_advertising') }}</a>
                </div>

                <div class="box-tools">
                    <form id="search" action="{{ Admin::action('index') }}">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="search" class="form-control pull-right"
                                   value="{{ request('search') }}"
                                   placeholder="{{ trans('admin.search_related') }}...">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body no-padding table-responsive">
                <table class="table table-hover table-striped">
                    <tbody>
                    <tr class="nowrap">
                        <th><input type="checkbox" class="grid-select-all"></th>
                        <th>ID</th>
                        <th>{{ trans('admin.title') }}</th>
                        <th>Slug</th>
                        <th>{{ trans('admin.ads_count') }}</th>
                        <th>{{ trans('admin.updated_at') }}</th>
                        <th>{{ trans('admin.operating') }}</th>
                    </tr>
                    @foreach($results as $ad)
                        <tr>
                            <td>
                                <input type="checkbox" class="grid-row-checkbox" data-id="{{ $ad->id }}">
                            </td>
                            <td>{{ $ad->id }}</td>
                            <td>{{ $ad->title }}</td>
                            <td>{{ $ad->slug }}</td>
                            <td>{{ $ad->links_count }}</td>
                            <td>{{ $ad->updated_at }}</td>
                            <td>
                                <a href="{{ Admin::action('edit', $ad->id) }}">{{ trans('admin.edit') }}</a>&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" data-id="{{ $ad->id }}" data-url="{{ request()->getPathInfo() }}" class="grid-row-delete">{{ trans('admin.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="pull-left">
                    {{ trans('admin.pagination.range', [
                    'first' => $results->firstItem(),
                    'last' => $results->lastItem(),
                    'total' => $results->total(),
                    ]) }}
                </div>

                <div class="pull-right">
                    {{ $results->appends(request()->query())->links() }}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- end panel -->
</div>

@endsection