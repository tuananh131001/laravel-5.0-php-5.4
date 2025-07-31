<?php

namespace App\Http\Controllers;

use App\Card;
use App\Client;
use App\CardTransaction;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the spending report form.
     *
     * @return Response
     */
    public function spendingForm()
    {
        $clients = Client::pluck('name', 'id');
        return view('reports.spending', compact('clients'));
    }

    /**
     * Generate the spending report.
     *
     * @param  Request  $request
     * @return Response
     */
    public function generateSpendingReport(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'nullable|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $query = CardTransaction::with(['card.client', 'card.product'])
            ->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);

        if ($request->filled('client_id')) {
            $query->whereHas('card', function ($q) use ($request) {
                $q->where('client_id', $request->client_id);
            });
        }

        $transactions = $query->get();

        $summary = [
            'total_amount' => $transactions->sum('amount'),
            'transaction_count' => $transactions->count(),
            'unique_cards' => $transactions->pluck('card_id')->unique()->count()
        ];

        return view('reports.spending_results', compact('transactions', 'summary'));
    }

    /**
     * Show the card cancellation report form.
     *
     * @return Response
     */
    public function cancellationForm()
    {
        $clients = Client::pluck('name', 'id');
        return view('reports.cancellation', compact('clients'));
    }

    /**
     * Generate the card cancellation report.
     *
     * @param  Request  $request
     * @return Response
     */
    public function generateCancellationReport(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'nullable|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $query = Card::with(['client', 'product'])
            ->where('status', 'cancelled')
            ->whereBetween('cancelled_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $cards = $query->get();

        $summary = [
            'total_cards' => $cards->count(),
            'unique_clients' => $cards->pluck('client_id')->unique()->count(),
            'unique_products' => $cards->pluck('product_id')->unique()->count()
        ];

        return view('reports.cancellation_results', compact('cards', 'summary'));
    }
}