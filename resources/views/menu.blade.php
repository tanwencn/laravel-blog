@foreach($items as $val)
    <li class="{{ $val->has('children') ? "treeview" : "" }} {{ url()->current() == $val->get('url') ? "active" : "" }}">
        <a href="{{ $val->get('url') }}">
            <i class="fa {{ $val->get('icon') }}"></i> <span>{{ $val->get('name') }}</span>
            @if($val->has('children'))
                <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
            @endif
        </a>
        @if ($val->has('children'))
            <ul class="treeview-menu">
                {!! view('admin::menu', [
            'items' => $val->get('children')
        ]) !!}
            </ul>
        @endif
    </li>
@endforeach