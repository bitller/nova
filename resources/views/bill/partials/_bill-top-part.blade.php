<!-- BEGIN Bill top part -->
<div class="add-client-button btn-toolbar">

    @include('bill.partials.bill-top-part-partials._client-name-and-campaign-details')


    <!-- BEGIN Action buttons -->
    <div class="action-buttons btn-toolbar pull-right">

        @include('bill.partials.bill-top-part-partials._print-button')

        <!-- BEGIN Options button -->
        <div class="btn-group">

            @include('bill.partials.bill-top-part-partials._options-button')

            <ul class="dropdown-menu">
                @include('bill.partials.bill-top-part-partials._edit-other-details-option')
                @include('bill.partials.bill-top-part-partials._set-payment-term-option')
                @include('bill.partials.bill-top-part-partials._mark-as-paid-option')
                @include('bill.partials.bill-top-part-partials._mark-as-unpaid-option')
                <li class="divider"></li>
                @include('bill.partials.bill-top-part-partials._delete-bill-option')
            </ul>

        </div>
        <!-- END Options button -->

        @include('bill.partials.bill-top-part-partials._add-product-to-bill-button')

    </div>
    <!-- END Action buttons -->

</div>
<!-- BEGIN Bill top part -->