<!-- BEGIN Client name and campaign details -->
<span class="my-clients-title">

    <!-- BEGIN Client name -->
    <a href="/clients/@{{ bill.data.client_id }}">
        @{{ bill.data.client_name }}
    </a>
    <!-- END Client name -->

    - {{ trans('bill.order') }} @{{ bill.data.campaign_order }} {{ trans('bill.from_campaign') }}

    <!-- BEGIN Campaign details -->
    <a href="/statistics/campaign/@{{ bill.data.campaign_number }}/@{{ bill.data.campaign_year }}">
        @{{ bill.data.campaign_number }}/@{{ bill.data.campaign_year }}
    </a>
    <!-- END Campaign details -->

    &nbsp;&nbsp;<span v-show="paid > 0" class="paid-bill glyphicon glyphicon-ok" data-toggle="tooltip" title="{{ trans('bill.tooltip') }}" data-placement="right"></span>
</span>
<!-- END Client name and campaign details -->