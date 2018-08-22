<div class="box box-solid collapsed-box" id="{!! $class !!}">
    <!-- /.box-header -->
    <div class="box-header with-border">
        <h3 class="box-title">{{ $name }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                        class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body select-box" style="display: none;">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#{{ $class_name }}_all" aria-controls="all" role="tab"
                   data-toggle="tab">{{ trans('admin.all') }}</a>
            </li>
            <li role="presentation">
                <a href="#{{ $class_name }}_search" aria-controls="profile" role="tab"
                   data-toggle="tab">{{ trans('admin.search') }}</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="{{$class_name }}_all">
                @if($data->isEmpty())
                    <span style="color: #a09e9e">{{ trans('admin.no_items') }}</span>
                @else
                    <ul>
                        @foreach($data as $val)
                            @include('admin::widgets.menu_setting_panel')
                        @endforeach
                    </ul>
                @endif
            </div>
            <div role="tabpanel" class="tab-pane form-inline" id="{{ $class_name }}_search">
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
               value="{{ trans('admin.add_to_menu') }}">
    </div>
</div>
       