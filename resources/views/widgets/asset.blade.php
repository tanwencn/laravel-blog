@if($type == 'css')

    @if($is_file)
        <link rel="stylesheet" href="{{ $content }}">
    @else
        <style>
            {{ $content }}
        </style>
    @endif

@endif

@if($type == 'js')

    @if($is_file)
        <script src="{{ $content }}"></script>
    @else
        <script>
            {{ $content }}
        </script>
    @endif

@endif