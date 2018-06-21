@extends('admin::layouts.app')

@section('title', trans_choice('admin.comment', 1))

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
                            @can('edit_page')
                                <li><a href="javascript:void(0)" class="grid-batch-release"
                                       data-value="1">{{ trans('admin.release') }}</a></li>
                                <li><a href="javascript:void(0)" class="grid-batch-release"
                                       data-value="0">{{ trans('admin.draft') }}</a></li>
                                <li role="separator" class="divider"></li>
                            @endcan
                            @can('delete_comment')
                                <li>
                                    <a href="javascript:void(0)" class="grid-batch-delete" data-url="{{ request()->getPathInfo() }}">{{ trans('admin.delete') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </div>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default btn-sm grid-release {{ request('release')?:'active' }}"
                               data-value="">{{ trans('admin.all') }}{{ $statistics['total'] }})
                        </label>
                        <label class="btn btn-default btn-sm grid-release {{ request('release')=='up'?'active':'' }}"
                               data-value="up">{{ trans('admin.release') }}({{ $statistics['release'] }})
                        </label>
                        <label class="btn btn-default btn-sm grid-release {{ request('release')=='down'?'active':'' }}"
                               data-value="down">{{ trans('admin.draft') }}({{ $statistics['unrelease'] }})
                        </label>
                    </div>

                    <div class="box-tools">
                        <form id="search" action="{{ Admin::action('index') }}">
                            <input type="hidden" name="release" value="{{ request('release') }}">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" value="{{ request('search') }}" placeholder="{{ trans('admin.search_related') }}...">

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
                            <th>{{ trans('admin.username') }}</th>
                            <th>{{ trans('admin.content') }}</th>
                            <th>{{ trans('admin.reply') }}</th>
                            <th>{{ trans('admin.release') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.operating') }}</th>
                        </tr>
                        @foreach($results as $model)
                            <tr>
                                <td>
                                    <input type="checkbox" class="grid-row-checkbox" data-id="{{ $model->id }}">
                                </td>
                                <td>
                                    {{ $model->id }}
                                </td>
                                <td>{{ $model->user->name }}</td>
                                <td>{{ $model->content }}</td>
                                <td>{{ $model->reply_history }}</td>
                                <td>
                                    <input type="checkbox"
                                           @cannot('edit_comment') readonly @endcannot
                                           data-key="{{ $model->id }}"
                                           data-onname="{{ trans('admin.release') }}"
                                           data-offname="{{ trans('admin.draft') }}"
                                           class="grid-switch-released" {{ $model->is_release?'checked':'' }} />
                                </td>
                                <td>{{ $model->created_at }}</td>
                                <td>
                                    <a href="{{ $model->commentable->url }}" target="_blank">{{ trans('admin.view') }}</a> &nbsp;
                                    @can('delete_comment')
                                        <a href="javascript:void(0);"
                                           data-id="{{ $model->id }}"
                                           data-url="{{ request()->getPathInfo() }}"
                                           class="grid-row-delete">{{ trans('admin.delete') }}</a>
                                    @endcan
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

    <script>
        $(function () {

            $('.grid-switch-released').bootstrapSwitch({
                size: 'mini',
                onText: '{{ trans('admin.yes') }}',
                offText: '{{ trans('admin.no') }}',
                onSwitchChange: function (event, state) {
                    var pk = $(this).data('key');
                    var value = state ? '1' : '0';
                    $.ajax({
                        method: 'post',
                        url: '{{ Admin::action('index') }}/' + pk,
                        data: {
                            _method: 'PUT',
                            _token: "{{ csrf_token() }}",
                            is_release: value,
                            _only: "is_release"
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        }
                    });
                }
            });

            $('.grid-batch-release').on('click', function () {
                var selected = listSelectedRows();
                if (!selected) {
                    return false;
                }
                var id = selected.join();
                var value = $(this).data('value');
                $.ajax({
                    method: 'post',
                    url: '{{ request()->getPathInfo() }}/' + id,
                    data: {
                        _method: 'PUT',
                        _token: "{{ csrf_token() }}",
                        is_release: value,
                        _only: "is_release"
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');
                        toastr.success(data.message);
                    }
                });
            });

            $('.grid-release').click(function () {
                var release = $(this).data('value');
                $('#search [name="release"]').val(release);
                $('#search').submit();
            });
        });
    </script>
@endsection