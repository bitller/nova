<!-- BEGIN Bill table -->
<div class="panel panel-default" v-show="total !== '0.00' && bill.products">
    <table class="table table-bordered table-condensed bill-products-table">
        <thead>
            <tr class="bill-table-head">
                @include('bill.partials.bill-table-partials._page-column')
                @include('bill.partials.bill-table-partials._code-column')
                @include('bill.partials.bill-table-partials._name-column')
                @include('bill.partials.bill-table-partials._quantity-column')
                @include('bill.partials.bill-table-partials._price-column')
                @include('bill.partials.bill-table-partials._discount-column')
                @include('bill.partials.bill-table-partials._final-price-column')
                @include('bill.partials.bill-table-partials._delete-column')
            </tr>
        </thead>

        <tbody>
            <tr class="bill-table-content" v-repeat="product in bill.products">
                @include('bill.partials.bill-table-partials._page-value')
                @include('bill.partials.bill-table-partials._code-value')
                @include('bill.partials.bill-table-partials._name-value')
                @include('bill.partials.bill-table-partials._quantity-value')
                @include('bill.partials.bill-table-partials._price-value')
                @include('bill.partials.bill-table-partials._discount-value')
                @include('bill.partials.bill-table-partials._final-price-value')
                @include('bill.partials.bill-table-partials._delete-value')
            </tr>
        </tbody>
    </table>
</div>
<!-- END Bill table -->