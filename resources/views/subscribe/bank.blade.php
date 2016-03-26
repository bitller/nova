@extends('layout.index')
@section('content')

<!-- BEGIN Bank subscription -->
<div id="bank-subscription">

    <div class="col-sm-12 col-md-12 col-lg-12">

        <div class="well custom-well">
            <div class="row">
                @include('subscribe.bank-partials._info')
            </div>
        </div>

    </div>

</div>
<!-- END Bank subscription -->

@endsection

@section('scripts')

@endsection