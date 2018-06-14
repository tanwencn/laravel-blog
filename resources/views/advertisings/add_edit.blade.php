@extends('admin::layouts.app')

@section('title', trans_choice('admin.advertising', 1))

@section('breadcrumbs')
    <li><a href="{{ Admin::action('index') }}"> {{ trans('admin.ad_list') }}</a></li>
@endsection

@section('content')
<style>

    #sortable .dd-item.sortable-chosen{
        opacity:1;
    }
    #sortable .dd-item.sortable-ghost *{
        opacity:0.1;
    }
    #sortable .dd-item.sortable-ghost {display: block; position: relative; margin: 0; padding: 0; margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }


    #sortable .invalid{
        background-color: #f6c9cc !important;
        border-color: #f1acb1 !important;
    }

    #sortable .dd-item .dd-handle {
        position: absolute;
        margin: 0;
        left: 1px;
        top: 1px;
        cursor: pointer;
        width: 160px;
        white-space: nowrap;
        background: #fafafa;
        border: none !important;
    }

    #sortable .dd-item .dd-handle img {
        width: 140px;
        height: 100px;
    }

    #sortable .dd-item .operating {
        position: absolute;
        margin: 0;
        left: 11px;
        bottom: 6px;
        cursor: pointer;
        width: 140px;
        text-align: center;
    }

    #sortable .dd-item .dd-content {
        display: block;
        height: 30px;
        margin: 5px 0;
        padding: 5px 10px 5px 40px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        background: #fafafa;
        height: 140px;
        padding: 10px;
        padding-left: 170px;
        padding-right: 30px;
    }

    #sortable .dd-item .dd-content .form-group{
        padding-left: 80px;
    }

    #sortable .dd-item .dd-content .form-group label{
        width: 80px;
        margin-left: -80px;
        float: left;
        line-height: 30px;
    }

    #sortable .dd-item:hover .tree_branch_delete{
        display: inline-block;
    }

    #sortable .tree_branch_delete{
        color: #dd4b39;
        display: none;
        position: absolute;
        right: 8px;
        top: 2px;
    }
    #sortable .tree_branch_delete:hover{
        color: #fb8476;
    }
</style>
<script>
    var sortable_key = parseInt("{{ count($model->links) }}");

    var processHandle;
    function processSelectedFile(file, requestingField) {
        console.log(processHandle);
        $(processHandle).find('input').val(file.url);
        $(processHandle).find('img').attr('src', file.url);
        $(processHandle).find('img').attr('data-src', file.url);
        $(processHandle).find('img').css('opacity', 1);
    }

    function addItemLink(title, url){
        $('#sortable').append('<li class="dd-item"><div class="dd-handle"><img class="img-rounded" data-src="holder.js\/140x100?text=image" width="140" height="100"><input type="hidden" name="links['+ sortable_key +'][image]"><\/div><div class="operating"><a class="select-image" href="javascript:;">{{ trans("admin.select_image") }}<\/a><\/div><div class="dd-content"><div class="form-group"><label class="control-label">{{ trans("admin.title") }}:<\/label><input type="text" class="form-control input-sm" name="links['+ sortable_key +'][title]" value="'+ title +'"><\/div><div class="form-group"><label class="control-label">{{ trans("admin.description") }}:<\/label><input type="text" name="links['+ sortable_key +'][description]" value="'+ title +'" class="form-control input-sm"><\/div><div class="form-group"><label class="control-label">Url:<\/label><input type="text" name="links['+ sortable_key +'][url]" value="'+ url +'" class="form-control input-sm"><\/div><a href="javascript:void(0);" class="tree_branch_delete"><i class="fa fa-trash"><\/i><\/a><\/div><\/li>');
        sortable_key++;
        Holder.run();
    }

    function addItem(item){
        var image = item.data('image')==""?'<img class="img-rounded" data-src="holder.js\/140x100?text=image" width="140" height="100">':'<img class="img-rounded" src="'+ item.data('image') +'" style="opacity:0.2" width="140" height="100">';
        $('#sortable').append('<li class="dd-item"><input type="hidden" name="links['+ sortable_key +'][linkable_type]" value="'+ item.data('linkable_type') +'"><input type="hidden" name="links['+ sortable_key +'][linkable_id]" value="'+ item.data('linkable_id') +'"><div class="dd-handle">'+image+'<input type="hidden" name="links['+ sortable_key +'][image]"><\/div><div class="operating"><a class="select-image" href="javascript:;">{{ trans("admin.select_image") }}<\/a><\/div><div class="dd-content"><div class="form-group"><label class="control-label">{{ trans("admin.title") }}:<\/label><input type="text" class="form-control input-sm" name="links['+ sortable_key +'][title]" value="" placeholder="'+ item.data('title') +'"><\/div><div class="form-group"><label class="control-label">{{ trans("admin.description") }}:<\/label><input type="text" name="links['+ sortable_key +'][description]" value="'+ item.data('title') +'" class="form-control input-sm"><\/div><div class="form-group"><label class="control-label">Url:<\/label><input type="text" disabled value="'+ item.data('linkable_name') +'('+ item.data('title') +')" class="form-control input-sm"><\/div><a href="javascript:void(0);" class="tree_branch_delete"><i class="fa fa-trash"><\/i><\/a><\/div><\/li>');
        sortable_key++;
        Holder.run();
    }

</script>

<div class="menus-frame">
    <div class="sidebar-settings">
        {{ Widget::group('admin_menu_sides')->display() }}

        {{--@foreach($multiple_choice_sidebar as $class => $item)

            <div class="box box-solid collapsed-box">
                <!-- /.box-header -->
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $item['name'] }}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body select-box" style="display: none;">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#{{ $class }}_all" aria-controls="all" role="tab"
                               data-toggle="tab">{{ trans('admin.all') }}</a>
                        </li>
                        <li role="presentation">
                            <a href="#{{ $class }}_search" aria-controls="profile" role="tab"
                               data-toggle="tab">{{ trans('admin.search') }}</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="{{$class }}_all">
                            @if($item['data']->isEmpty())
                                <span style="color: #a09e9e">{{ trans('admin.no_items') }}</span>
                            @else
                                <ul>
                                    @recursive($item['data'])
                                    <li>
                                        <label>
                                            <input value="{{ $val->id }}" data-image="{{ $val->image }}"
                                                   data-linkable_name="{!! $args[0] !!}" data-title="{{ $val->title }}"
                                                   data-linkable_id="{{ $val->id }}"
                                                   data-linkable_type="{{ get_class($val) }}"
                                                   data-title="{{ $val->title }}" type="checkbox">
                                            <font>{{ $val->title }}</font>
                                        </label>
                                        @isset($val->children)
                                            @nextrecursive(
                                            <ul class="children">,</ul>)
                                        @endisset
                                    </li>
                                    @endrecursive($item['name'])
                                </ul>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane form-inline" id="{{ $title }}_search">
                            <div class="form-group" style="margin-bottom: 10px">
                                <input type="search" class="form-control input-sm" style="width: 160px; float: left;">
                                <button type="button" class="btn btn-default btn-sm btn-search"
                                        style="width: 52px; margin-left: 2px">
                                    {{ trans('admin.search') }}
                                </button>
                            </div>
                            <ul>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="select-all">{{ trans('admin.select_all') }}</a>

                    <input type="button" class="btn btn-default pull-right btn-sm add-item"
                           value="{{ trans('admin.add_to_ad') }}">
                </div>
            </div>
        @endforeach--}}

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
                        {{ trans('admin.add_to_ad') }}
                    </button>
                </p>
            </div>
            <!-- /.box-body -->
        </div>

    </div>

    <div class="menu-main">
        <form method="post" action="{{ Admin::action('form', $model) }}">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title form-inline">
                        <input hidden name="links">
                        {{ csrf_field() }}
                        @if(isset($model->id))
                            {{ method_field("PUT") }}
                        @endif
                        <div class="form-group {{ $errors->has('title')?"has-error":"" }}">
                            <label class="control-label" for="menu-name">{{ trans('admin.ad_name') }}</label>
                            <input type="text" name="title" class="form-control input-sm"
                                   placeholder="{{ trans('admin.ad_name') }}"
                                   value="{{ old('title', $model->title) }}">
                        </div>
                        <div class="form-group {{ $errors->has('slug')?"has-error":"" }}">
                            <input type="text" name="slug" class="form-control input-sm" placeholder="Slug"
                                   value="{{ old('slug', $model->slug) }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                            {{ trans('admin.save_ad') }}
                        </button>
                    </h4>
            </div>
            <div class="panel-body">
                <div class="callout" style="background-color: #eee !important;">{{ trans('admin.menu_operation_tips') }}</div>
                {{--<p><font style="vertical-align: inherit;">{{ trans('admin.menu_operation_tips') }}</font></p>--}}
                <div id="sortable">
                    @foreach($model->links as $key => $link)
                    <li class="dd-item">
                        @if($link->hasLinkable())
                            <input type="hidden" name="links[{{ $key }}][linkable_id]" value="{{ $link->linkable_id }}">
                            <input type="hidden" name="links[{{ $key }}][linkable_type]" value="{{ $link->linkable_type }}">
                        @endif
                        <div class="dd-handle">
                            @if(!empty($link->image))
                                <img class="img-rounded" src="{{ $link->image }}" width="140" height="100"><input type="hidden" name="links[{{ $key }}][image]" value="{{ $link->image }}">
                            @else
                                @if(!empty($link->linkable->image))
                                    <img class="img-rounded" src="{{ $link->linkable->image }}" width="140" height="100" style="opacity: 0.2">
                                @else
                                    <img class="img-rounded" data-src="holder.js/140x100?text=image" width="140" height="100">
                                @endif
                                <input type="hidden" name="links[{{ $key }}][image]" value="">
                            @endif
                        </div>
                        <div class="operating"><a class="select-image" href="javascript:;">{{ trans('admin.select_image') }}</a></div>
                        <div class="dd-content">
                            <div class="form-group">
                                <label class="control-label">{{ trans('admin.title') }}:</label>
                                <input type="text" class="form-control input-sm @isset($link->invalid) invalid @endisset" name="links[{{ $key }}][title]" value="{{ $link->getOriginal('title') }}" placeholder="{{ $link->title }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ trans('admin.description') }}:</label>
                                <input type="text" name="links[{{ $key }}][description]" class="form-control input-sm @isset($link->invalid) invalid @endisset" value="{{ $link->description }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Url:</label>
                                <input type="text" name="links[{{ $key }}][url]" class="form-control input-sm @isset($link->invalid) invalid @endisset" {{ $link->hasLinkable()?'disabled':'' }} value="{{ $link->hasLinkable()?Admin::getMenuSideNames($link->linkable_type).'('. $link->linkable->title .')':$link->url }}">
                            </div>
                            <a href="javascript:void(0);" class="tree_branch_delete"><i class="fa fa-trash"></i></a>
                        </div>
                    </li>
                    @endforeach
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        Holder.run();

        $('#sortable').on('click', '.operating .select-image', function(){
            processHandle = $(this).closest('.dd-item').find('.dd-handle');
            showImageSelector('image?multiple=false');
        });

        Sortable.create(sortable, {
            animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
            //handle: ".tile__title", // Restricts sort start click/touch to the specified element
            draggable: "li"
        });

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