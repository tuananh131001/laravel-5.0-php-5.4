@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Product Details
                    <a href="{{ route('products.index') }}" class="btn btn-default btn-xs pull-right">Back to List</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Brand</th>
                                    <td>{{ $product->brand->name }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="label label-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Custom Fields</th>
                                    <td>
                                        @if ($product->custom_fields)
                                            <ul class="list-unstyled">
                                                @foreach ($product->custom_fields as $key => $value)
                                                    <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            No custom fields
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Clients with Access</h3>
                            @if ($product->clients->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Payout Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->clients as $client)
                                            <tr>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ number_format($client->payout_rate, 2) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No clients have access to this product.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Issued Cards</h3>
                            @if ($product->cards->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Activation Number</th>
                                            <th>Status</th>
                                            <th>Issued At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->cards as $card)
                                            <tr>
                                                <td>{{ $card->client->name }}</td>
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
                                <p>No cards have been issued for this product.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
                            
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Product</button>
                            </form>
                            
                            <form action="{{ route('products.toggle-status', $product->id) }}" method="POST" style="display: inline;">
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-warning">
                                    {{ $product->status == 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection