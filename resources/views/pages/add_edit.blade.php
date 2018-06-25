@extends('admin::layouts.app')

@section('title', trans('admin.'.($model->id?'edit_page':'add_page')))

@section('content')
<style>
    .panel-group .panel-heading{
        cursor: pointer;
    }

    .tab-pane {
        min-height: 42px;
        max-height: 200px;
        overflow: auto;
        padding: 12px;
        border: 1px solid #ddd;
        background-color: #fdfdfd;
    }

    .tab-pane ul {
        padding: 0;
        list-style: none;
    }

    .tab-pane ul li {
        margin: 0;
        padding: 0 0 0 21px;
        line-height: 18px;
        display: list-item;
        list-style: none;
        position: relative;
    }

    .tab-pane ul li label {
        margin-bottom: 8px;
        font-weight: normal !important;
        cursor: pointer;
    }

    .tab-pane ul li div {
        position: absolute;
        top: 1px;
        left: 0;
    }




    [aria-expanded="false"] .fa-angle-up {
        display: none;
    }

    [aria-expanded="true"] .fa-angle-down {
        display: none;
    }

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

    .posts{
        margin-right: 300px;
    }
    .posts-left{
        float: left;
        width: 100%;
    }
    .posts-right{
        float: right;
        width: 280px;
        margin-right: -300px;
    }
</style>

@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger fade in" style="margin-bottom: 10px;">
            {{ $error }}.
            <span class="close" data-dismiss="alert">×</span>
        </div>
    @endforeach
@endif

<form data-pjax="true" action="{{ Admin::action('form', $model) }}"
      method="POST">
{{ csrf_field() }}
@if(isset($model->id))
    {{ method_field("PUT") }}
@endif
<!-- begin row -->
    <div class="posts">
        <!-- begin col-12 -->
        <div class="posts-left">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-2">{{ trans('admin.title') }}：</label>
                            <div class="col-md-8">
                                <input type="text" name="title" class="form-control" value="{{ old('title', $model->title)}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body" style="padding: 5px;">
                    <div class="form-group">
                        <textarea class="description" name="metas[description]">{{ old('metas.description', $model->description) }}</textarea>
                    </div>

                </div>
            </div>
        </div>
        <div class="posts-right">
            <div class="right-panel">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans_choice('admin.setting', 0) }}</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label>URL {{ trans('admin.slug') }}</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $model->slug)}}">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin.release') }}</label>
                            <select name="is_release" class="form-control">
                                <option value="0" {{ old('is_release', $model->is_release)==0?'selected':''}}>{{ trans('admin.draft') }}</option>
                                <option value="1" {{ old('is_release', $model->is_release)!=0?'selected':''}}>{{ trans('admin.release') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('admin.cover') }}<a class="pull-right" href="javascript:showImageSelector('gallery?multiple=false')" style=" color: #337ab7 !important">{{ trans('admin.select_image') }}</a></h3>
                    </div>

                    <div class="panel-body" style="padding: 10px">
                        <div id="gallery">
                            @if(!empty(old('metas.image', $model->image)))
                                <div class="col-md-12">
                                    <img class="img-rounded img-responsive" src="{{ old('metas.image', $model->image) }}">
                                    <input name="metas[image]" value="{{ old('metas.image', $model->image) }}" type="hidden">
                                    <button type="button" class="btn btn-box-tool delete" data-original-title="Remove">
                                        <i class="fa fa-times"></i></button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

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
            file_picker_callback: function(cb, value, meta) {
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

    });

</script>
@endsection