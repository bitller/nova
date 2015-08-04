<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nova</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Nova</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-btn">
                        <a href="/login" class="btn btn-default custom-button">Conecteaza-te</a>
                    </p>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="first-section">
    <div class="container">
        <h2 class="text-center welcome-text">Bun venit</h2>
        <h4 class="text-center description-text">Nova este o aplicatie de facturare si management al facturilor dedicata reprezentantilor Avon</h4>
        <div class="col-md-12 text-center start-button">
            <a href="/register"><button class="btn btn-default custom-button">Incepe sa folosesti Nova</button></a>
        </div>
    </div>
</div>

<div class="second-section">
    <div class="container">
        <h3 class="text-center why-nova">De ce sa folosesti Nova?</h3>
        <div class="col-md-4">
            <img class="img-center center-block" src="{{ url('/img/add.png') }}">
            <h4 class="text-center">Creeaza o noua factura in cateva secunde</h4>
            <h5 class="text-center">Ai primit o noua comanda? Dureaza doar cateva secunde sa creezi o noua factura</h5>
        </div>
        <div class="col-md-4">
            <img class="img-center center-block" src="{{ url('/img/easy-access.png') }}">
            <h4 class="text-center">Access rapid la toate facturile</h4>
            <h5 class="text-center">Vrei sa gasesti o factura de acum o luna sau un an? Nimic mai simplu. Ai access rapid la toate facturile</h5>
        </div>
        <div class="col-md-4">
            <img class="img-center center-block" src="{{ url('/img/print.png') }}">
            <h4 class="text-center">Printeaza facturile simplu si rapid</h4>
            <h5 class="text-center">Ai creat o noua comanda? Ai adaugat toate produsele si totul este gata? Atunci printeaza factura pentru a o da clientului</h5>
        </div>
    </div>

    <div class="container">
        <div class="col-md-4">
            <img class="img-center center-block" src="{{ url('/img/code.png') }}">
            <h4 class="text-center">Adauga produsele dupa codul lor</h4>
            <h5 class="text-center">Dupa cum stiti, fiecare produs avon are un cod din 5 cifre. Pentru a adauga un produs la o factura, nu trebuie de cat sa introduceti codul produsului din catalogul avon iar de restul se ocupa aplicatia</h5>
        </div>

        <div class="col-md-4">
            <img class="img-center center-block" src="{{ url('/img/stats.png') }}">
            <h4 class="text-center">Statistici despre vanzari</h4>
            <h5 class="text-center">Aveti la dispozitie statistici despre vanzarile efectuate, cele mai vandute produse, campania cu cele mai mari vanzari si multe altele</h5>
        </div>

        <div class="col-md-4">
            <img class="img-center center-block" src="{{ url('/img/search.png') }}">
            <h4 class="text-center">Cauta un produs dupa cod</h4>
            <h5 class="text-center">Baza noastra de date contine toate produsele avon, iar pentru a gasi rapid un produs trebuie doar sa ii stiti codul din 5 cifre din catalogul avon</h5>
        </div>

    </div>

</div>

</body>

</html>