@extends('admin::layouts.app')

@section('title', trans_choice('admin.menu', 1))

@section('content')
    <script>
        function serializeMenus() {
            $('input[name="links"]').val(JSON.stringify($('.dd').nestable('serialize')));
            return true;
        }

        function addItemLink(title, url) {
            $('.menu-main').find('.dd-list:first').append('<li class="dd-item" data-linkable_type="" data-title="' + title + '" data-linkable_id="" data-url="' + url + '">' +
                '<div class="dd-handle">' + title + '<span class="pull-right dd-nodrag"><font style="padding-right:10px">{{ trans_choice('admin.custom_link', 0) }}<\/font><a href="javascript:void(0);" class="tree_branch_delete"><i class="fa fa-trash"><\/i><\/a></span><\/div><\/li>');
        }

        function addItem(item) {
            $('.menu-main').find('.dd-list:first').append('<li class="dd-item" data-linkable_type="' + item.data('linkable_type') + '" data-title="" data-linkable_id="' + item.data('linkable_id') + '">' +
                '<div class="dd-handle">' + item.data('title') + '<span class="pull-right dd-nodrag"><font style="padding-right:10px">' + item.data('linkable_name') + '<\/font><a href="javascript:void(0);" class="tree_branch_delete"><i class="fa fa-trash"><\/i><\/a></span><\/div><\/li>');
        }
    </script>

    <div class="panel panel-inverse" style="margin-bottom: 10px">
        <div class="panel-body">
            <div class="form-inline">
                <div class="form-group">
                    <span>{{ trans('admin.select_a_menu_edit') }}: </span>
                    <select class="form-control input-sm" name="menus">
                        <option value="" selected>{{ trans('admin.select_a_menu') }}</option>
                        @foreach($menus->all() as $menu)
                            <option {{ $menu->id==$model->id?'selected':'' }} value="{{ Admin::action('edit', $menu->id) }}">{{ $menu->title }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-default btn-sm btn-edit">
                        {{ trans('admin.select') }}
                    </button>
                    <span> or <a href="{{ Admin::action('create') }}">{{ trans('admin.create_a_menu') }}</a></span>
                </div>
            </div>
        </div>
    </div>

    <div class="menus-frame">

        <div class="sidebar-settings">
            {{ Widget::group('admin_menu_sides')->display() }}
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans_choice('admin.custom_link', 0) }}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active">
                            <div class="form-group">
                                <label class="control-label" for="menu-name" style="line-height: 30px">URL</label>
                                <input type="text" name="url" class="form-control input-sm" value="http://"
                                       style="width: 150px; float: right">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="menu-name" style="line-height: 30px">
                                    {{ trans('admin.link_text') }}
                                </label>
                                <input type="text" name="title" class="form-control input-sm"
                                       style="width: 150px; float: right">
                            </div>
                        </div>
                    </div>

                    <p style="height: 30px; line-height: 30px; margin: 10px 0 0 0;">
                        <button type="button" class="btn btn-default btn-sm pull-right add-item-link">
                            {{ trans('admin.add_to_menu') }}
                        </button>
                    </p>
                </div>
                <!-- /.box-body -->
            </div>

        </div>

        <div class="menu-main">
            @if(isset($invalid) && $invalid)
                <div class="callout callout-danger">
                    <p>{{ trans('admin.invalid_prompt') }}</p>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <form method="post" data-pjax="true"
                          action="{{ Admin::action('form', $model) }}"
                          onsubmit="return serializeMenus(this)">
                        <h4 class="panel-title form-inline">
                            <input hidden name="links">
                            {{ csrf_field() }}
                            @if(isset($model->id))
                                {{ method_field("PUT") }}
                            @endif
                            <div class="form-group {{ $errors->has('title')?"has-error":"" }}">
                                <label class="control-label" for="menu-name">{{ trans('admin.menu_name') }}</label>
                                <input type="text" name="title" class="form-control input-sm"
                                       placeholder="{{ trans('admin.menu_name') }}"
                                       value="{{ old('title', $model->title) }}">
                            </div>
                            <div class="form-group {{ $errors->has('slug')?"has-error":"" }}">
                                <input type="text" name="slug" class="form-control input-sm"
                                       placeholder="{{ trans('admin.slug') }}"
                                       value="{{ old('slug', $model->slug) }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                {{ trans('admin.save_menu') }}
                            </button>
                        </h4>
                    </form>
                </div>
                <div class="panel-body">
                    <div class="callout"
                         style="background-color: #eee !important;">{{ trans('admin.menu_operation_tips') }}</div>
                    {{--<p><font style="vertical-align: inherit;">{{ trans('admin.menu_operation_tips') }}</font></p>--}}
                    <div class="dd" style="margin: 0;">
                        <?php //dd($model->links->recursive('children'))?>
                        @foreach($model->links->recursive() as $item)
                            {!! str_repeat('<ol class="dd-list">', $item["start_label"]) !!}
                            <li class="dd-item"
                                data-title="{{ $item['original']['title'] }}"
                                data-linkable_id="{{ $item['linkable_id'] }}"
                                data-linkable_type="{{ $item['linkable_type'] }}"
                                data-url="{{ $item['original']['url'] }}">
                                <div class="dd-handle @if($item['invalid']) invalid @endif">
                                    {{ $item['title'] }}
                                    <span class="pull-right dd-nodrag">
                                        <font style="padding-right:10px">
                                            {{ $item['linkable_type']?Admin::side()->names($item['linkable_type']):trans_choice('admin.custom_link', 0) }}
                                        </font>
                                        <a href="javascript:void(0);" class="tree_branch_delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </span>
                                </div>
                            {!! str_repeat('</li></ol>', $item["closed_label"]) !!}
                        @endforeach
                    </div>

                    {{--<p style="height: 30px; line-height: 30px; margin: 10px 0 0 0;">
                        <button type="submit" class="btn btn-primary btn-sm btn-block" style="width: 120px; float: right">
                            保存菜单
                        </button>
                    </p>--}}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.dd').nestable();

            $('.menu-main').on('click', '.tree_branch_delete', function () {
                $(this).closest('li').remove();
            });

            $(':input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                increaseArea: '20%' // optional
            });

            $('.add-item-link').click(function () {
                var node = $(this).closest('.box').find('.tab-content .tab-pane.active');
                var url = $(node).find('input[name="url"]').val();
                var title = $(node).find('input[name="title"]').val();
                if (url.length > 0 && title.length > 0) {
                    addItemLink(title, url);
                }
            });

            $('.add-item').click(function () {
                var nodes = $(this).closest('.box').find('.tab-content .tab-pane.active input[type="checkbox"]:checked');
                $.each(nodes, function (index, node) {
                    node = $(node);
                    addItem(node);
                });
            });

            $('.select-all').click(function () {
                nodels = $(this).closest('.box').find('.tab-content .tab-pane.active input[type="checkbox"]');
                notChecked = $(nodels).not(':checked');

                if (notChecked.length > 0) {
                    nodels.iCheck('check');
                } else {
                    nodels.iCheck('uncheck');
                }
            });

            $('.btn-search').click(function () {
                var cur = $(this).closest('.tab-pane').find('ul');
                var search = $(this).prev().val().replace(' ', '').toLowerCase();
                var nodels = $(this).closest('.box').find('.tab-content .tab-pane:first label font');
                var html = '';
                $.each(nodels, function (index, val) {
                    var text = $(val).text().toLowerCase();
                    if (text.indexOf(search) >= 0) {
                        var node = $(val).closest('li').clone(true);
                        $(node).find('ul').remove();
                        $(node).find('label').prepend($(node).find('input').removeAttr('style').prop("outerHTML"));
                        $(node).find('div').remove();
                        html += node.prop("outerHTML");
                    }
                });
                if (html == '')
                    html = "<span style=\"color: #a09e9e\">{{ trans('admin.no_items') }}</span>";
                cur.html(html);
                $(':input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    increaseArea: '20%' // optional
                });
            });

            $('.btn-edit').click(function () {
                var url = $('select[name="menus"]').val();
                if (url)
                    $.pjax({url: url, container: '#pjax-container'});
            });
        });
    </script>
@endsection