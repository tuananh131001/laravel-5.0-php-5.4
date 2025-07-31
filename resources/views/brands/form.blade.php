@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($brand) ? 'Edit Brand' : 'Create Brand' }}</div>

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

                    @if (isset($brand))
                        <form class="form-horizontal" method="POST" action="{{ route('brands.update', $brand->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('brands.store') }}">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name', isset($brand) ? $brand->name : '') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select name="status" class="form-control">
                                    <option value="active" {{ old('status', isset($brand) ? $brand->status : '') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', isset($brand) ? $brand->status : '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Custom Fields</label>
                            <div class="col-md-6">
                                <div id="custom-fields">
                                    @if (isset($brand) && $brand->custom_fields)
                                        @foreach ($brand->custom_fields as $key => $value)
                                            <div class="custom-field-row">
                                                <input type="text" class="form-control" style="width: 45%; display: inline-block;" name="custom_fields[keys][]" value="{{ $key }}" placeholder="Field Name">
                                                <input type="text" class="form-control" style="width: 45%; display: inline-block;" name="custom_fields[values][]" value="{{ $value }}" placeholder="Field Value">
                                                <button type="button" class="btn btn-danger btn-xs remove-field">Remove</button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success btn-xs" id="add-field" {{ isset($brand) && count($brand->custom_fields) >= 5 ? 'disabled' : '' }}>Add Custom Field</button>
                                <small class="text-muted">Maximum 5 custom fields allowed</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($brand) ? 'Update Brand' : 'Create Brand' }}
                                </button>
                                <a href="{{ route('brands.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#add-field').click(function() {
        var fieldCount = $('.custom-field-row').length;
        if (fieldCount >= 5) {
            alert('Maximum 5 custom fields allowed');
            return;
        }

        var newField = '<div class="custom-field-row">' +
            '<input type="text" class="form-control" style="width: 45%; display: inline-block;" name="custom_fields[keys][]" placeholder="Field Name">' +
            '<input type="text" class="form-control" style="width: 45%; display: inline-block;" name="custom_fields[values][]" placeholder="Field Value">' +
            '<button type="button" class="btn btn-danger btn-xs remove-field">Remove</button>' +
            '</div>';

        $('#custom-fields').append(newField);
        
        if (fieldCount + 1 >= 5) {
            $('#add-field').prop('disabled', true);
        }
    });

    $(document).on('click', '.remove-field', function() {
        $(this).closest('.custom-field-row').remove();
        $('#add-field').prop('disabled', false);
    });
});
</script>
@endpush
@endsection