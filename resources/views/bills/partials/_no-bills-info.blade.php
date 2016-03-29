<!-- BEGIN No bills info -->
<div class="alert alert-info no-bills-info" v-show="!bills.total && !search_results">

    <div class="row">
        <div class="col-md-1">
            <img class="img-responsive center-responsive-image" src="/img/mail.svg">
        </div>
        <div class="col-md-11 alert-col">
                <span>
                    {{ trans('bills.no_bills') }}
                    <a href="#" data-target="#how-to-create-bills-help-modal" data-toggle="modal">
                        {{ trans('bills.click_here_to_see_what_to_do') }}
                    </a>
                </span>
        </div>
    </div>

</div>
<!-- END No bills info -->