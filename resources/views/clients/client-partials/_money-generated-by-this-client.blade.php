<!-- BEGIN Money generated by this client -->
<div class="col-md-6">

    <!-- BEGIN Well --->
    <div class="well custom-well grey-text">

        <!-- BEGIN Generated money text -->
        <div>
            <strong>
                {{ trans('clients.money_generated_by_this_client') }}: @{{ client.statistics.earnings }} ron
            </strong>
        </div>
        <!-- END Generated money text -->

        <!-- BEGIN More details -->
        <div>
            <span class="more-details">@{{ client.money_generated }}</span>
        </div>
        <!-- END More details -->

    </div>
    <!-- END Well -->

</div>
<!-- END Money generated by this client -->