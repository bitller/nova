<!-- BEGIN Add bill -->
<div class="add-bill-button">

    <!-- BEGIN Bills title -->
    <span class="my-bills-title">
        {{ trans('bills.my_bills') }}
    </span>
    <!-- END Bills title -->

    <!-- BEGIN Search button -->
    <button v-on="click: toggleSearchBar()" class="btn btn-default">
        <i class="glyphicon glyphicon-search"></i>
    </button>
    <!-- END Search button -->

    <!-- BEGIN Add bill button -->
    <button type="button" data-toggle="modal" data-target="#create-bill-modal" v-on="click: resetCreateBillModal()" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-plus"></span>
        {{ trans('bills.create') }}
    </button>
    <!-- END Add bill button -->

    <!-- BEGIN Search bar -->
    <div class="form-group search-bar" style="margin-top: 15px;">
        <input type="text" v-on="keyup:search | key 13" v-model="search_input" class="form-control" placeholder="{{ trans('bills.search_bills_placeholder') }}"/>
    </div>
    <!-- END Search bar -->

</div>
<!-- END Add bill-->