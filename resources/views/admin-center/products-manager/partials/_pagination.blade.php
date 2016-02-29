<!-- BEGIN Pagination links -->
<div>
    <ul class="pager">

        <!-- BEGIN Results info -->
        <div class="pull-left text-left col-md-5 results-info">
            <span>
                {{ trans('products_manager.showing') }} @{{ products.to-products.from+1 }} {{ trans('products_manager.out_of') }} @{{ products.total }} {{ trans('products_manager.products') }}
            </span>
        </div>
        <!-- END Results info -->

        <!-- BEGIN Buttons -->
        <div class="col-md-7 text-left">

            <!-- BEGIN Prev button -->
            <li v-class="disabled : !products.prev_page_url">
                <a href="#" v-on="click: getProducts(products.prev_page_url)">
                    {{ trans('common.previous') }}
                </a>
            </li>
            <!-- END Prev button -->

            <!-- BEGIN Next button -->
            <li v-class="disabled : !products.next_page_url">
                <a href="#" v-on="click: getProducts(products.next_page_url)">
                    {{ trans('common.next') }}
                </a>
            </li>
            <!-- END Next button -->

        </div>
        <!-- END Buttons -->

    </ul>
</div>
<!-- END Pagination links -->