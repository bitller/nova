<!-- BEGIN Dropdown -->
<div class="btn-group">

    <!-- BEGIN Button -->
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon {{ $icon or 'glyphicon-th-large' }}"></span>&nbsp;
        <span class="caret"></span>
    </button>
    <!-- END Button -->

    <ul class="dropdown-menu">

        <!-- BEGIN Menu items -->
        @foreach($items as $item)
        <li>
            <a href="{{ $item['url'] }}">
                <span class="glyphicon {{ $item['icon'] }}"></span>&nbsp; {{ $item['name'] }}
            </a>
        </li>
        @endforeach
        <!-- END Menu items -->

    </ul>
</div>
<!-- END Dropdown -->