@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($client) ? 'Edit Client' : 'Create Client' }}</div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (isset($client))
                        <form class="form-horizontal" method="POST" action="{{ route('clients.update', $client->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('clients.store') }}">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name', isset($client) ? $client->name : '') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email', isset($client) ? $client->email : '') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" {{ isset($client) ? '' : 'required' }}>
                                @if (isset($client))
                                    <small class="text-muted">Leave blank to keep current password</small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" {{ isset($client) ? '' : 'required' }}>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payout_rate" class="col-md-4 control-label">Payout Rate (%)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="payout_rate" value="{{ old('payout_rate', isset($client) ? $client->payout_rate : '') }}" step="0.01" min="0" max="100" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="products" class="col-md-4 control-label">Accessible Products</label>
                            <div class="col-md-6">
                                <select name="products[]" class="form-control" multiple size="10">
                                    @foreach ($products as $id => $name)
                                        <option value="{{ $id }}" {{ isset($selectedProducts) && in_array($id, $selectedProducts) ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($client) ? 'Update Client' : 'Create Client' }}
                                </button>
                                <a href="{{ route('clients.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection