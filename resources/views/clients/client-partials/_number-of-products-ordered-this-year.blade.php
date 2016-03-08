<!-- BEGIN Number of products ordered this year -->
<div class="col-md-6">

    <!-- BEGIN Custom well -->
    <div class="well custom-well grey-text">

        <!-- BEGIN Products ordered text -->
        <div>
            <strong>{{ trans('clients.number_of_products_ordered_this_year') }}: @{{ client.statistics.number_of_products_ordered_this_year }}</strong>
        </div>
        <!-- END Products ordered text -->

        <!-- BEGIN More details -->
        <div>
            <span class="more-details">@{{ client.number_of_products_sold_this_year }}</span>
        </div>
        <!-- END More details -->

    </div>
    <!-- END Custom well -->

</div>
<!-- END Number of products ordered this year -->