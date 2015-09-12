@extends('layout')
@section('content')
    <div id="bill">
        <h4><a href="#">John Doe</a></h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Page</th>
                <th>Code</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Final price</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>4</td>
                <td>29</td>
                <td>01497</td>
                <td>Ceas Asier</td>
                <td>1</td>
                <td>10.00</td>
                <td>10%</td>
                <td>9.00</td>
            </tr>
            <tr>
                <td>4</td>
                <td>29</td>
                <td>01497</td>
                <td>Ceas Asier</td>
                <td>1</td>
                <td>10.00</td>
                <td>10%</td>
                <td>9.00</td>
            </tr>
            <tr>
                <td>4</td>
                <td>29</td>
                <td>01497</td>
                <td>Ceas Asier</td>
                <td>1</td>
                <td>10.00</td>
                <td>10%</td>
                <td>9.00</td>
            </tr>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection