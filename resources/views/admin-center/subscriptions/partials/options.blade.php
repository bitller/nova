<!-- BEGIN Subscriptions options -->
<div v-show="!loading_{{ $tab }}_subscriptions && {{ $tab }}_subscriptions.total > 0" class="dropdown">

    <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span id="user-email">{{ $name }}</span><span class="caret"></span>
    </h5>

    <ul class="dropdown-menu">
        @foreach ($options as $option)
            <li>
                <a href="#" v-on="click: {{ $option['action_on_click'] }}">
                    <span class="glyphicon {{ $option['icon'] }}">&nbsp;</span> {{ $option['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
<!-- END Subscriptions options -->