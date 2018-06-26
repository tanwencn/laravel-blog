@extends('admin::layouts.app')

@section('title', trans('admin.general_settings'))

@section('content')
<style>
    .form-horizontal input[type="text"],select {
        max-width: 500px !important;
    }
</style>
<form method="POST" action="{{ url()->current() }}" class="form-horizontal">
<div class="box box-default">
    <div class="box-header"></div>
    <div class="box-body">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="web_name" class="col-sm-3 control-label">{{ trans('admin.web_name') }}</label>
                <div class="col-sm-9">
                    <input name="options[web_name]" type="text" class="form-control" id="web_name"
                           value="{{ old('options.web_name', option('web_name')) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="web_desc" class="col-sm-3 control-label">{{ trans('admin.web_desc') }}</label>
                <div class="col-sm-9">
                    <input name="options[web_desc]" type="text" class="form-control" id="web_desc"
                           value="{{ old('options.web_name', option('web_desc')) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="web_url" class="col-sm-3 control-label">{{ trans('admin.web_url') }}(URL)</label>
                <div class="col-sm-9">
                    <input name="options[web_url]" type="text" class="form-control" id="web_url"
                           value="{{ old('options.web_name', option('web_url')) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="web_url" class="col-sm-3 control-label">{{ trans('admin.web_logo') }}(Logo)</label>
                <div class="col-sm-9">
                    <input readonly style="width:300px; float: left" name="options[web_logo]" type="text"
                           class="form-control" id="web_logo" value="{{ old('options.web_logo', option('web_logo')) }}">
                    <button type="button" style="width: auto; float: left;"
                            class="btn btn-default select-image"><i class="glyphicon glyphicon-folder-open"></i> {{ trans('admin.select_image') }}</button>
                </div>
            </div>

            <div class="form-group">
                <label for="web_url" class="col-sm-3 control-label">{{ trans('admin.theme') }}</label>
                <div class="col-sm-9">
                    <select name="options[theme]" class="form-control">
                        @foreach($themes as $theme)
                            <option value="{{ $theme->name }}" {{ old('theme', option('theme', 'default'))==$theme->name?'selected':''}}>{{ $theme->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    </div>
    <div class="box-footer clearfix">
        <button type="button" style="width: 120px"
        class="btn btn-primary pull-right btn-save">{{ trans('admin.save') }}</button>
    </div>
</div>
</form>

<script>

    function processSelectedFile(file, requestingField) {
        $('#web_logo').val(file.url);
    }

    $(function () {
        $('.select-image').click(function () {
            showImageSelector('logo?multiple=false');
        });

        $('.btn-save').click(function(){
            var form = $(this).parents('form');
            $.post(form.attr('action'), form.serialize(), function(data){
                if(data.status){
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }
            }, 'json');
        });
    });
</script>
@endsection