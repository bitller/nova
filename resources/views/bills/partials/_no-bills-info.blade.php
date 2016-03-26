<!-- BEGIN No bills info -->
<div class="alert alert-info no-bills-info" v-show="!bills.total && !search_results">

    {{ trans('bills.no_bills') }}

    <a href="#" data-target="#how-to-create-bills-help-modal" data-toggle="modal">
        {{ trans('bills.click_here_to_see_what_to_do') }}
    </a>

</div>
<!-- END No bills info -->