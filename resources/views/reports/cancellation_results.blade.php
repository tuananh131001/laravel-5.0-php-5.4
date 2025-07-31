@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Card Cancellation Report Results
                    <a href="{{ route('reports.cancellation') }}" class="btn btn-default btn-xs pull-right">Back to Report Form</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Summary</h3>
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Total Cards Cancelled</th>
                                    <td>{{ $summary['total_cards'] }}</td>
                                </tr>
                                <tr>
                                    <th>Unique Clients</th>
                                    <td>{{ $summary['unique_clients'] }}</td>
                                </tr>
                                <tr>
                                    <th>Unique Products</th>
                                    <td>{{ $summary['unique_products'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Cancelled Cards Details</h3>
                            @if ($cards->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cancellation Date</th>
                                            <th>Client</th>
                                            <th>Product</th>
                                            <th>Activation Number</th>
                                            <th>Issue Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cards as $card)
                                            <tr>
                                                <td>{{ $card->cancelled_at->format('Y-m-d H:i:s') }}</td>
                                                <td>{{ $card->client->name }}</td>
                                                <td>{{ $card->product->name }}</td>
                                                <td>{{ $card->activation_number }}</td>
                                                <td>{{ $card->created_at->format('Y-m-d H:i:s') }}</td>
                                                <td>
                                                    <a href="{{ route('cards.show', $card->id) }}" class="btn btn-xs btn-info">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No cancelled cards found for the selected criteria.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('reports.cancellation') }}" class="btn btn-default">Generate Another Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection