@extends('admin::layouts.app')

@section('title', trans('admin.'.($model->id?'edit_post':'add_post')))

@section('breadcrumbs') <li><a href="{{ Admin::action('index') }}"> {{ trans('admin.all_post') }}</a></li> @endsection

@section('content')
<style>
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        vertical-align: middle;
    }

    #gallery div {
        margin: 6px 0;
        padding: 0 3px;
        cursor: move;
    }

    #gallery div img {
        width: 100% !important;
    }

    #gallery div .delete {
        padding: 0 3px;
        margin: 0;
        position: absolute;
        top: -3px;
        right: 0px;
        color: #000000;
        background: #fff;
        display: none;
    }
</style>

<form action="{{ Admin::action('form', $model) }}" method="POST">
{{ csrf_field() }}
@if(isset($model->id))
    {{ method_field("PUT") }}
@endif
<!-- begin row -->
    <div class="posts">
        <!-- begin col-12 -->
        <div class="posts-left">
            <div class="box box-solid">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-horizontal">
                        <div class="form-group {{ $errors->has('title')?"has-error":"" }}">
                            <label class="control-label col-md-2">{{ trans('admin.title') }}：</label>
                            <div class="col-md-8">
                                @if($errors->has('title'))
                                    <label class="control-label">
                                        <i class="fa fa-times-circle-o"></i>{{$errors->first('title')}}
                                    </label>
                                @endif
                                <input type="text" name="title" class="form-control" value="{{ old('title', $model->title)}}">
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('excerpt')?"has-error":"" }}">
                            <label class="control-label col-md-2">{{ trans('admin.excerpt') }}：</label>
                            <div class="col-md-8">
                                @if($errors->has('excerpt'))
                                    <label class="control-label">
                                        <i class="fa fa-times-circle-o"></i>{{$errors->first('excerpt')}}
                                    </label>
                                @endif
                                <textarea type="text" class="form-control"
                                          name="excerpt">{{ old('excerpt', $model->excerpt)}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="form-group">
                        <textarea class="description"
                                  name="metas[description]">{{ old('metas.description', $model->description) }}</textarea>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="posts-right">
            <div class="right-panel">
                <!-- settting -->
                <div class="box box-solid">
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans_choice('admin.setting', 0) }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>URL {{ trans('admin.slug') }}</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $model->slug)}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">{{ trans_choice('admin.tag', 0) }}：</label>
                            <select class="select2 select-tags form-control" multiple="multiple" name="tags[]">
                                <option value=""></option>
                                @foreach ($tags as $item)
                                    <option {{ in_array($item->id, $model->tags) ? 'selected="selected" ' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="url-slug-input">{{ trans('admin.release') }}</label>
                            <select name="is_release" class="form-control">
                                <option value="0" {{ old('is_release', $model->is_release)==0?'selected':''}}>{{ trans('admin.draft') }}</option>
                                <option value="1" {{ old('is_release', $model->is_release)!=0?'selected':''}}>{{ trans('admin.release') }}</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- settting -->

                <!-- category -->
                <div class="box box-solid">
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans_choice('admin.post_category', 1) }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="tab-content select-box">
                            <div role="tabpanel" class="tab-pane active" id="select_categories" style="border-top: 1px solid #ddd;">
                                <ul>
                                    @recursive($categories)
                                    <li>
                                        <label>
                                            <input name="categories[]" {{ in_array($val->id, $args[0])?"checked":'' }} value="{{ $val->id }}" data-image="{{ $val->image }}"
                                                   data-linkable_name="{{ trans_choice('tanwencms::admin.'.snake_case(class_basename($val)), 0) }}"
                                                   data-title="{{ $val->title }}" data-linkable_id="{{ $val->id }}"
                                                   data-linkable_type="{{ get_class($val) }}"
                                                   data-title="{{ $val->title }}" type="checkbox">
                                            <font>{{ $val->title }}</font>
                                        </label>
                                        @if(!empty($val->children))
                                            @nextrecursive(
                                            <ul class="children">,</ul>)
                                        @endif
                                    </li>
                                    @endrecursive($model->categories)
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- category -->

                <!-- cover -->
                <div class="box box-solid">
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin.cover') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <a class="pull-right"
                           href="javascript:showImageSelector('gallery?multiple=false')"
                           style=" color: #337ab7 !important">{{ trans('admin.select_image') }}</a>
                        <div id="gallery">
                            @if(!empty(old('metas.image', $model->image)))
                                <div class="col-md-12">
                                    <img class="img-rounded img-responsive"
                                         src="{{ old('metas.image', $model->image) }}">
                                    <input name="metas[image]" value="{{ old('metas.image', $model->image) }}"
                                           type="hidden">
                                    <button type="button" class="btn btn-box-tool delete" data-original-title="Remove">
                                        <i class="fa fa-times"></i></button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- cover -->

                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ trans('admin.save') }}</button>
            </div>
        </div>
        <!-- end panel -->
        <!-- end col-12 -->
    </div>
</form>
<!-- end row -->

<!-- end #content -->


<script>
    // function to update the file selected by elfinder

    var processSelectedFileId = '';

    function processSelectedFile(file, requestingField) {
        if (requestingField == 'tinymce4') {
            processSelectedFileId(file.url);
            //$('#' + processSelectedFileId).val(file.url);
        } else {
            $('#' + requestingField).html('<div class="col-md-12"><img class="img-rounded img-responsive" src="' + file.url + '"><input name="metas[image]" value="' + file.url + '" type="hidden"><button type="button" class="btn btn-box-tool delete" data-original-title="Remove"><i class="fa fa-times"><\/i><\/button><\/div>');
        }
    }

    $('#gallery').on('click', '.delete', function () {
        $(this).parent().remove();
    });

    $('#gallery').on('mouseover', 'div', function () {
        $(this).find('.delete').show();
    });
    $('#gallery').on('mouseout', 'div', function () {
        $(this).find('.delete').hide();
    });


    $(function () {

        $('[name="title"]').keyup(function(){
            $('[name="slug"]').val(slugify($(this).val()));
        });

        $(':input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            increaseArea: '20%' // optional
        });

        tinymce.init({
            selector: '.description',
            skin: 'voyager',
            height: 300,
            menubar: true,
            convert_urls: false,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                processSelectedFileId = cb;
                showImageSelector("tinymce4?multiple=false&id='+field_name");
            },
            plugins: [
                'advlist autolink lists link image code charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
            content_css: [
                '{{ asset('vendor/laravel-blog/tinymce/skins/lightgray/content.min.css') }}',
            ]
        });


        $('.select2').select2({
            allowClear: true,
            placeholder: $(this).data('data-placeholder'),
            templateSelection: function (state) {
                return $.trim(state.text);
            }
        });


        $('.goods-select-attributes [type="text"]').not(':disabled').each(function (index, val) {
            data.attributes[$(val).data('value')] = $(val).val();
        });

        $('.goods-stock-table thead tr').each(function (index, val) {
            var code = '';
            var value = {};
            $(val).find('input').each(function (i, v) {
                code = $(v).data('code');
                value[$(v).data('field')] = $(v).val();
            });
            data.goods[code] = value;
        });

        $('.select-box .tab-pane.active').slimScroll({
            height: '200px',
            railVisible: true,
            alwaysVisible: true
        });
    });

</script>
@endsection
