<li>
    <label>
        <input value="{{ $val->id }}" data-image="{{ $val->image }}"
               data-linkable_name="{!! $name !!}" data-title="{{ $val->title }}"
               data-linkable_id="{{ $val->id }}"
               data-linkable_type="{{ get_class($val) }}"
               data-title="{{ $val->title }}" type="checkbox">
        <font>{{ $val->title }}</font>
    </label>
    @isset($val->children)
        <ul class="children">
            @foreach($val->children as $item)
                @include('admin::widgets.menu_setting_panel', ['val' => $item])
            @endforeach
        </ul>
    @endisset
</li>