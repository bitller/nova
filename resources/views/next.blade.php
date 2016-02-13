@extends('layout')
@section('content')
    <div id="next">

        <div class="alert alert-success welcome-alert">
            <span class="glyphicon glyphicon-ok"></span>&nbsp;
            {{ trans('next.welcome') }}
        </div>

        <div class="fancy-divider">
            <span>{{ trans('next.what_is_next') }}</span>
        </div>

        <div class="first-step">
            <div class="well custom-well">
                <h4>Incepe sa creezi facturi pentru clientii tai</h4>
                <h5 class="grey-text">Acceseaza pagina cu facturi dand click pe "Nova" din bara de sus, apoi click pe "Creaza factura" si completeaza cu numele clientului. Gata, tocami ai creat prima ta factura. Felicitari! <a href="#">Click aici pentru video</a></h5>
            </div>
        </div>

        <div class="second-step">
            <div class="well custom-well">
                <h4>Adauga produse in factura tocmai creata</h4>
                <h5 class="grey-text">O factura este inutila daca nu contine produse. <a href="#">Vezi aici cum adaugi produse in factura ta!</a></h5>
            </div>
        </div>

        <div>
            <div class="well custom-well">
                <h4>Tipareste factura</h4>
                <h5 class="grey-text">Ai adaugat toate produsele? Aplicatia a calculat tot ce era de calculat? Acum trebuie doar sa tiparesti factura pentru a o inmana clientului impreuna cu comanda sa. <a href="#">Vezi aici cum</a></h5>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection