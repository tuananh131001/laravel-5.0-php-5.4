@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Card Cancellation Report</div>

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

                    <form class="form-horizontal" method="POST" action="{{ route('reports.cancellation.generate') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="client_id" class="col-md-4 control-label">Client (Optional)</label>
                            <div class="col-md-6">
                                <select name="client_id" class="form-control">
                                    <option value="">All Clients</option>
                                    @foreach ($clients as $id => $name)
                                        <option value="{{ $id }}" {{ old('client_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Start Date</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', date('Y-m-d', strtotime('-30 days'))) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="col-md-4 control-label">End Date</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Generate Report</button>
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