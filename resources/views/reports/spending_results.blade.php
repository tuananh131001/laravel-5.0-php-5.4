@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Spending Report Results
                    <a href="{{ route('reports.spending') }}" class="btn btn-default btn-xs pull-right">Back to Report Form</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Summary</h3>
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Total Amount</th>
                                    <td>{{ number_format($summary['total_amount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Transactions</th>
                                    <td>{{ $summary['transaction_count'] }}</td>
                                </tr>
                                <tr>
                                    <th>Unique Cards Used</th>
                                    <td>{{ $summary['unique_cards'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Transaction Details</h3>
                            @if ($transactions->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Product</th>
                                            <th>Card</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                                <td>{{ $transaction->card->client->name }}</td>
                                                <td>{{ $transaction->card->product->name }}</td>
                                                <td>{{ $transaction->card->activation_number }}</td>
                                                <td>{{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}</td>
                                                <td>{{ $transaction->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No transactions found for the selected criteria.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('reports.spending') }}" class="btn btn-default">Generate Another Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection