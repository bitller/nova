<!-- BEGIN Number of products ordered -->
<div class="col-md-6">

    <!-- BEGIN Custom well -->
    <div class="well custom-well grey-text">

        <!-- BEGIN Number of products ordered text -->
        <div>
            <strong>{{ trans('clients.number_of_products_ordered') }}: @{{ client.statistics.number_of_products_ordered }}</strong>
        </div>
        <!-- END Number of products ordered text -->

        <!-- BEGIN More details about number of products ordered -->
        <div>
            <span class="more-details">@{{ client.number_of_products_sold }}</span>
        </div>
        <!-- END More details about number of products ordered -->

    </div>
    <!-- END Custom well -->

</div>
<!-- END Number of products ordered -->