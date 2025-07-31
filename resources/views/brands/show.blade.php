@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Brand Details
                    <a href="{{ route('brands.index') }}" class="btn btn-default btn-xs pull-right">Back to List</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ $brand->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="label label-{{ $brand->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($brand->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Custom Fields</th>
                                    <td>
                                        @if ($brand->custom_fields)
                                            <ul class="list-unstyled">
                                                @foreach ($brand->custom_fields as $key => $value)
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
                                    <td>{{ $brand->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $brand->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Products</h3>
                            @if ($brand->products->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brand->products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->currency }} {{ number_format($product->price, 2) }}</td>
                                                <td>
                                                    <span class="label label-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-xs btn-info">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No products found for this brand.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary">Edit Brand</a>
                            
                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display: inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Brand</button>
                            </form>
                            
                            <form action="{{ route('brands.toggle-status', $brand->id) }}" method="POST" style="display: inline;">
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-warning">
                                    {{ $brand->status == 'active' ? 'Deactivate' : 'Activate' }}
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