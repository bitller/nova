<!-- BEGIN No search results -->
<div class="alert alert-info" v-show="!bills.total && search_results">

    <div class="row">
        <div class="col-md-1">
            <img class="img-responsive center-responsive-image" src="/img/caution.svg">
        </div>
        <div class="col-md-11 alert-col">
            <span>
                {{ trans('bills.no_search_results') }}
                <a v-on="click:hideSearch" href="#">
                    {{ trans('bills.click_here_to_see_all_bills') }}
                </a>
            </span>
        </div>
    </div>
</div>
<!-- END No search results -->