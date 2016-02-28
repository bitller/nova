<!-- BEGIN No search results -->
<div class="alert alert-info" v-show="!bills.total && search_results">
    {{ trans('bills.no_search_results') }}
    <a v-on="click:hideSearch" href="#">
        {{ trans('bills.click_here_to_see_all_bills') }}
    </a>
</div>
<!-- END No search results -->