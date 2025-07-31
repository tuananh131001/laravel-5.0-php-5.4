@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Clients
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-xs pull-right">Add New Client</a>
                </div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Payout Rate</th>
                                <th>Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ number_format($client->payout_rate, 2) }}%</td>
                                    <td>{{ $client->products->count() }}</td>
                                    <td>
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-xs btn-primary">Edit</a>
                                            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-xs btn-info">View</a>
                                            
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $clients->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection