@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Client Details
                    <a href="{{ route('clients.index') }}" class="btn btn-default btn-xs pull-right">Back to List</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ $client->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <th>Payout Rate</th>
                                    <td>{{ number_format($client->payout_rate, 2) }}%</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $client->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $client->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Accessible Products</h3>
                            @if ($client->products->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->products as $product)
                                            <tr>
                                                <td>{{ $product->brand->name }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                                                <td>
                                                    <span class="label label-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No products assigned to this client.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Issued Cards</h3>
                            @if ($client->cards->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Activation Number</th>
                                            <th>Status</th>
                                            <th>Issued At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->cards as $card)
                                            <tr>
                                                <td>{{ $card->product->name }}</td>
                                                <td>{{ $card->activation_number }}</td>
                                                <td>
                                                    <span class="label label-{{ $card->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($card->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $card->created_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No cards have been issued to this client.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">Edit Client</a>
                            
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Client</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection