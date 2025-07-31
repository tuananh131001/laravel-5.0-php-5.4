@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Cards</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('cards.create') }}" class="btn btn-primary btn-sm">Issue New Card</a>
                    </div>
                </div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Activation Number</th>
                                <th>Status</th>
                                <th>Issued At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cards as $card)
                                <tr>
                                    <td>{{ $card->client ? $card->client->name : 'N/A' }}</td>
                                    <td>{{ $card->product ? $card->product->name : 'N/A' }}</td>
                                    <td>{{ $card->activation_number }}</td>
                                    <td>
                                        <span class="label label-{{ $card->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($card->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $card->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('cards.show', $card->id) }}" class="btn btn-xs btn-info">View</a>
                                        
                                        @if ($card->status === 'active')
                                            <form action="{{ route('cards.cancel', $card->id) }}" method="POST" style="display: inline;">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to cancel this card?')">Cancel</button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display: inline;" class="delete-card-form">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $cards->render() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-card-form').on('submit', function(e) {
        e.preventDefault();
        
        if (!confirm('Are you sure you want to delete this card?')) {
            return false;
        }

        var form = $(this);
        var row = form.closest('tr');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                row.fadeOut(400, function() {
                    $(this).remove();
                    
                    // Show success message
                    var alert = $('<div class="alert alert-success">')
                        .text('Card deleted successfully.')
                        .hide();
                    
                    $('.panel-body').prepend(alert);
                    alert.fadeIn();
                    
                    // Remove the alert after 3 seconds
                    setTimeout(function() {
                        alert.fadeOut(400, function() {
                            $(this).remove();
                        });
                    }, 3000);
                });
            },
            error: function(xhr) {
                alert('Error deleting card. Please try again.');
            }
        });
    });
});
</script>
@endpush