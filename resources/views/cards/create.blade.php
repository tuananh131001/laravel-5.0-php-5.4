@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Issue New Card</div>

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

                    <form class="form-horizontal" method="POST" action="{{ route('cards.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="client_id" class="col-md-4 control-label">Client</label>
                            <div class="col-md-6">
                                <select name="client_id" class="form-control" required>
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $id => $name)
                                        <option value="{{ $id }}" {{ old('client_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product_id" class="col-md-4 control-label">Product</label>
                            <div class="col-md-6">
                                <select name="product_id" class="form-control" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $id => $name)
                                        <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pin" class="col-md-4 control-label">PIN (Optional)</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="pin" value="{{ old('pin') }}" pattern="[0-9]{4}" maxlength="4" placeholder="4-digit PIN">
                                <small class="text-muted">Leave blank if no PIN is required</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Issue Card</button>
                                <a href="{{ route('cards.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection