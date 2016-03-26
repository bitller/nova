<!-- BEGIN How to create bills help modal -->
<div id="how-to-create-bills-help-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('help_modals.how_to_create_bills_title')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <iframe width="560" height="315" src="https://www.youtube.com/embed/wGCJpqdvk5Q" frameborder="0" allowfullscreen></iframe>

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.one_button_footer')

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END How to create bills help modal -->