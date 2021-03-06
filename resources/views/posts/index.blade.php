@extends('admin::layouts.app')

@section('title', trans_choice('admin.all_post', 1))

@section('content')
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <form id="search" data-pjax="true" action="{{ Admin::action('index') }}">
                        <input type="hidden" name="trashed" value="{{ request('trashed', 0) }}">
                        <input type="hidden" name="release" value="{{ request('release') }}">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" name="search"
                                       value="{{ request('search') }}" class="form-control"
                                       placeholder="{{ trans('admin.search_related') }}...">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search f-s-14"></i> {{ trans('admin.search') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box box-default">
                <!-- /.box-header -->
                <div class="box-header">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm">{{ trans('admin.batch') }}</button>
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @can('admin.edit_post')
                            <li><a href="javascript:void(0)" class="grid-batch-release"
                                   data-value="1">{{ trans('admin.release') }}</a></li>
                            <li><a href="javascript:void(0)" class="grid-batch-release"
                                   data-value="0">{{ trans('admin.draft') }}</a></li>
                            <li role="separator" class="divider"></li>
                            @endcan
                            @if(request('trashed'))
                                @can('admin.edit_post')
                                <li><a href="javascript:void(0)"
                                       class="grid-batch-restore">{{ trans('admin.restore') }}</a>
                                </li>
                                @endcan
                                @can('admin.delete_post')
                                <li><a href="javascript:void(0)" class="grid-batch-delete"
                                       data-url="{{ request()->getPathInfo() }}">{{ trans('admin.delete_permanently') }}</a>
                                </li>
                                @endcan
                            @else
                                @can('admin.delete_post')
                                <li><a href="javascript:void(0)" class="grid-batch-delete" data-type="trash"
                                       data-url="{{ request()->getPathInfo() }}">{{ trans('admin.move_trash') }}</a>
                                </li>
                                @endcan
                            @endif
                        </ul>
                    </div>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default btn-sm grid-trashed {{ request('trashed')?'active':'' }}">
                            <i class="fa f-s-12 fa-trash-o"></i> {{ trans('admin.trash') }}{{ $statistics['delete'] }})
                        </label>
                    </div>

                    @if(empty(request('trashed')))
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
                    @endif
                    @can('admin.add_post')
                    <a class="btn btn-sm btn-success pull-right" href="{{ Admin::action('create') }}"><i
                                class="fa fa-plus f-s-12"></i> {{ trans('admin.add_post') }}</a>
                    @endcan
                </div>
                <div class="box-body no-padding table-responsive">
                    <table class="table table-hover table-striped">
                        <tbody>
                        <tr class="nowrap">
                            <th><input type="checkbox" class="grid-select-all"></th>
                            <th>ID</th>
                            <th>{{ trans('admin.cover') }}</th>
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans_choice('admin.category', 0) }}</th>
                            <th>{{ trans_choice('admin.tag', 0) }}</th>
                            @if(!request('trashed'))
                                <th>{{ trans('admin.release') }}</th>
                            @endif
                            <th>{{ trans('admin.updated_at') }}</th>
                            <th>{{ trans('admin.operating') }}</th>
                        </tr>
                        @foreach($results as $posts)
                            <tr>
                                <td>
                                    <input type="checkbox" class="grid-row-checkbox" data-id="{{ $posts->id }}">
                                </td>
                                <td>
                                    {{ $posts->id }}
                                </td>
                                <td>
                                    <img src="{{ $posts->image }}" style="max-height: 40px">
                                </td>
                                <td>{{ $posts->title }}</td>
                                <td>{{ $posts->categories->implode('title', ',') }}</td>
                                <td>{{ $posts->tags->implode('title', ',') }}</td>
                                @if(!request('trashed'))
                                    <td>
                                        <input type="checkbox"
                                               @cannot('edit_post') readonly @endcannot
                                               data-key="{{ $posts->id }}"
                                               data-onname="{{ trans('admin.release') }}"
                                               data-offname="{{ trans('admin.draft') }}"
                                               class="grid-switch-released" {{ $posts->is_release?'checked':'' }} />
                                    </td>
                                @endif
                                <td>{{ $posts->updated_at }}</td>
                                <td>
                                    @if(request('trashed'))
                                        @can('admin.edit_post')
                                        <a href="javascript:void(0);" data-id="{{ $posts->id }}"
                                           class="grid-row-restore">{{ trans('admin.restore') }}</a>&nbsp;&nbsp;&nbsp;
                                        @endcan
                                        @can('admin.delete_post')
                                        <a href="javascript:void(0);" data-id="{{ $posts->id }}" class="grid-row-delete"
                                           data-url="{{ request()->getPathInfo() }}"> {{ trans('admin.delete_permanently') }}</a>
                                        @endcan
                                    @else
                                        @can('admin.edit_post')
                                        <a href="{{ Admin::action('edit', $posts->id) }}">{{ trans('admin.edit') }}</a>
                                        &nbsp;&nbsp;&nbsp; @endcan
                                    @can('admin.delete_post')
                                        <a href="javascript:void(0);" data-id="{{ $posts->id }}" class="grid-row-delete"
                                           data-url="{{ request()->getPathInfo() }}"
                                           data-type="trash">{{ trans('admin.delete') }}</a>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="pull-left pagination">
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
                        url: '{{ request()->getPathInfo() }}/' + pk,
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

            $('.grid-batch-restore,.grid-row-restore').on('click', function () {
                if ($(this).hasClass('grid-row-restore')) {
                    var id = $(this).data('id');
                    if (!id)
                        return false;
                } else {
                    var selected = listSelectedRows();
                    if (!selected) {
                        return false;
                    }
                    var id = selected.join();
                }

                var value = $(this).data('value');
                $.ajax({
                    method: 'post',
                    url: '{{ Admin::action('index') }}/' + id,
                    data: {
                        _method: 'PUT',
                        _token: "{{ csrf_token() }}",
                        _only: "restore"
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');
                        toastr.success(data.message);
                    }
                });
            });

            $('.grid-trashed').click(function () {
                var trashed = $(this).hasClass('active') ? 0 : 1;
                $('#search [name="trashed"]').val(trashed);
                $('#search').submit();
            });
            $('.grid-release').click(function () {
                var release = $(this).data('value');
                $('#search [name="release"]').val(release);
                $('#search').submit();
            });

        });
    </script>
@endsection