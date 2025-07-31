@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Brands</h3>
                                </div>
                                <div class="panel-body">
                                    <h3>{{ App\Brand::count() }}</h3>
                                    <a href="{{ url('/brands') }}" class="btn btn-default btn-xs">Manage Brands</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Products</h3>
                                </div>
                                <div class="panel-body">
                                    <h3>{{ App\Product::count() }}</h3>
                                    <a href="{{ url('/products') }}" class="btn btn-default btn-xs">Manage Products</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Clients</h3>
                                </div>
                                <div class="panel-body">
                                    <h3>{{ App\Client::count() }}</h3>
                                    <a href="{{ url('/clients') }}" class="btn btn-default btn-xs">Manage Clients</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Cards</h3>
                                </div>
                                <div class="panel-body">
                                    <h3>{{ App\Card::count() }}</h3>
                                    <a href="{{ url('/cards') }}" class="btn btn-default btn-xs">Manage Cards</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Recent Cards</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Product</th>
                                                <th>Status</th>
                                                <th>Issued</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(App\Card::with(['client', 'product'])->orderBy('created_at', 'desc')->take(5)->get() as $card)
                                                <tr>
                                                    <td>{{ $card->client->name }}</td>
                                                    <td>{{ $card->product->name }}</td>
                                                    <td>
                                                        <span class="label label-{{ $card->status == 'active' ? 'success' : 'danger' }}">
                                                            {{ ucfirst($card->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $card->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Recent Transactions</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Card</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(App\CardTransaction::with('card.client')->orderBy('created_at', 'desc')->take(5)->get() as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->card->client->name }}</td>
                                                    <td>{{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}</td>
                                                    <td>{{ $transaction->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection