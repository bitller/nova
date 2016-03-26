<!-- BEGIN Company details modal -->
<div id="company-details-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('subscribe.company_details')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Info -->
                <div class="alert alert-info">
                    Daca nu puteti tipari detaliile necesare, le puteti nota undeva pentru a le avea la dispozitie atunci cand mergeti la banca.
                </div>
                <!-- END Info -->

                <div><strong>Detaliile necesare sunt urmatoarele</strong></div>
                <ul class="list-group">
                    <li class="list-group-item">Furnizor: <strong>Bitller S.R.L.</strong></li>
                    <li class="list-group-item"><span class="badge">5</span> Deleted</li>
                    <li class="list-group-item"><span class="badge">3</span> Warnings</li>
                </ul>
                <!-- BEGIN Company name -->
                <div>
                    <strong>Furnizor: Bitller S.R.L.</strong>
                </div>
                <!-- END Company name -->

                <!-- BEGIN Company register number -->
                <div>
                    <strong>Reg. com: 111/222/2010</strong>
                </div>
                <!-- END Company register number -->

                <!-- BEGIN Fiscal identification code -->
                <div>
                    <strong>CIF: 12345678</strong>
                </div>
                <!-- END Fiscal identification code -->

                <!-- BEGIN Company address -->
                <div>
                    <strong>Adresa: Strada y numarul 4, Timisoara, Romania</strong>
                </div>
                <!-- END Company address -->

                <!-- BEGIN IBAN -->
                <div>
                    <strong>IBAN: 123456789123456789</strong>
                </div>
                <!-- END IBAN -->

                <!-- BEGIN Bank -->
                <div>
                    <strong>Banca: ING BANK NV</strong>
                </div>
                <!-- END Bank -->

                <!-- BEGIN Social capital -->
                <div>
                    <strong>Social capital: 250</strong>
                </div>
                <!-- END Social capital -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.one_button_footer')

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Company details modal -->