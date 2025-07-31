@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Brands
                    <a href="{{ route('brands.create') }}" class="btn btn-primary btn-xs pull-right">Add New Brand</a>
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
                                <th>Status</th>
                                <th>Custom Fields</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <span class="label label-{{ $brand->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($brand->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($brand->custom_fields)
                                            <ul>
                                                @foreach ($brand->custom_fields as $key => $value)
                                                    <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            No custom fields
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display: inline;">
                                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-xs btn-primary">Edit</a>
                                            <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-xs btn-info">View</a>
                                            
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            
                                            <form action="{{ route('brands.toggle-status', $brand->id) }}" method="POST" style="display: inline;">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-warning">
                                                    {{ $brand->status == 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $brands->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection