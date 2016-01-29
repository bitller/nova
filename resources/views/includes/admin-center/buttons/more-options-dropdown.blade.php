<!-- BEGIN Dropdown -->
<div class="btn-group @if(isset($class)) {{ $class }} @endif">

    <!-- BEGIN Button -->
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        @if(isset($text))
            {{ $text }}
        @endif
        @if(isset($icon))
            <span class="glyphicon {{ $icon }}"></span>&nbsp;
        @endif
        <span class="caret"></span>
    </button>
    <!-- END Button -->

    <ul class="dropdown-menu">

        <!-- BEGIN Menu items -->
        @foreach($items as $item)
            <li @if(isset($item['on_click'])) v-on="click: {{ $item['on_click'] }}" @endif
                @if(isset($item['data_toggle'])) data-toggle="{{ $item['data_toggle'] }}" @endif
                @if(isset($item['data_target'])) data-target="{{ $item['data_target'] }}" @endif
            >
                <a href="{{ $item['url'] }}">
                    <span class="glyphicon {{ $item['icon'] }}"></span>&nbsp; {{ $item['name'] }}
                </a>
            </li>
        @endforeach
        <!-- END Menu items -->

    </ul>
</div>
<!-- END Dropdown -->