@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Card Details
                    <a href="{{ route('cards.index') }}" class="btn btn-default btn-xs pull-right">Back to List</a>
                </div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Client</th>
                                    <td>{{ $card->client ? $card->client->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                    <td>{{ $card->product ? $card->product->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Activation Number</th>
                                    <td>{{ $card->activation_number }}</td>
                                </tr>
                                <tr>
                                    <th>PIN</th>
                                    <td>{{ $card->pin ? str_repeat('*', strlen($card->pin)) : 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="label label-{{ $card->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($card->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Issued At</th>
                                    <td>{{ $card->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @if ($card->cancelled_at)
                                    <tr>
                                        <th>Cancelled At</th>
                                        <td>{{ $card->cancelled_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Transactions</h3>
                            @if ($card->transactions->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($card->transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                                <td>{{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}</td>
                                                <td>{{ $transaction->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No transactions found for this card.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($card->status === 'active')
                                <form action="{{ route('cards.cancel', $card->id) }}" method="POST" style="display: inline;">
                                    <input type="hidden" name="_method" value="PATCH">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to cancel this card?')">Cancel Card</button>
                                </form>
                            @endif
                            
                            <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display: inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Card</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection