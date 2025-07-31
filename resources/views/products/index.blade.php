@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-xs pull-right">Add New Product</a>
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
                                <th>Brand</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Custom Fields</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span class="label label-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($product->custom_fields)
                                            <ul>
                                                @foreach ($product->custom_fields as $key => $value)
                                                    <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            No custom fields
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-xs btn-primary">Edit</a>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-xs btn-info">View</a>
                                            
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            
                                            <form action="{{ route('products.toggle-status', $product->id) }}" method="POST" style="display: inline;">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-warning">
                                                    {{ $product->status == 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $products->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection