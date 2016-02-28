<!-- BEGIN Pagination links -->
<div>
    <ul class="pager">

        <!-- BEGIN Results info -->
        <div class="pull-left text-left col-md-5 results-info" v-show="bills.from">
            <span>
                {{ trans('bills.showing') }} @{{ bills.to-bills.from+1 }} {{ trans('bills.out_of') }} @{{ bills.total }} {{ trans('bills.bills') }}
            </span>
        </div>
        <!-- END Results info -->

        <!-- BEGIN Buttons -->
        <div class="col-md-7 text-left" v-show="(bills.total > bills.per_page) && show_pagination">

            <!-- BEGIN Prev button -->
            <li v-class="disabled : !bills.prev_page_url">
                <a href="#" v-on="click: paginate(bills.prev_page_url)">
                    {{ trans('common.previous') }}
                </a>
            </li>
            <!-- END Prev button -->

            <!-- BEGIN Next button -->
            <li v-class="disabled : !bills.next_page_url">
                <a href="#" v-on="click: paginate(bills.next_page_url)">
                    {{ trans('common.next') }}
                </a>
            </li>
            <!-- END Next button -->

        </div>
        <!-- END Buttons -->

    </ul>
</div>
<!-- END Pagination links -->