<!-- BEGIN Pagination links -->
<div v-show="myProducts.total > myProducts.per_page">
    <ul class="pager">

        <!-- BEGIN Results info -->
        <div class="pull-left text-left col-md-5 results-info">
            <span>
                {{ trans('products_manager.showing') }} @{{ myProducts.to-myProducts.from+1 }} {{ trans('products_manager.out_of') }} @{{ myProducts.total }} {{ trans('products_manager.products') }}
            </span>
        </div>
        <!-- END Results info -->

        <!-- BEGIN Buttons -->
        <div class="col-md-7 text-left">

            <!-- BEGIN Prev button -->
            <li v-class="disabled : !myProducts.prev_page_url">
                <a href="#" v-on="click: paginate(myProducts.prev_page_url)">
                    {{ trans('common.previous') }}
                </a>
            </li>
            <!-- END Prev button -->

            <!-- BEGIN Next button -->
            <li v-class="disabled : !myProducts.next_page_url">
                <a href="#" v-on="click: paginate(myProducts.next_page_url)">
                    {{ trans('common.next') }}
                </a>
            </li>
            <!-- END Next button -->

        </div>
        <!-- END Buttons -->

    </ul>
</div>
<!-- END Pagination links -->