<?php

namespace App\Http\Controllers;

use App\Card;
use App\Client;
use App\Product;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the cards.
     *
     * @return Response
     */
    public function index()
    {
        $cards = Card::with(['client', 'product'])->orderBy('created_at', 'desc')->paginate(10);
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new card.
     *
     * @return Response
     */
    public function create()
    {
        $clients = Client::lists('name', 'id');
        $products = Product::active()->lists('name', 'id');
        return view('cards.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created card in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id'
        ];

        if ($request->has('pin')) {
            $rules['pin'] = 'digits:4';
        }

        $this->validate($request, $rules);

        // Check if client has access to the product
        $client = Client::with('products')->findOrFail($request->client_id);
        $hasAccess = false;
        foreach ($client->products as $product) {
            if ($product->id == $request->product_id) {
                $hasAccess = true;
                break;
            }
        }
        if (!$hasAccess) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['product_id' => 'Client does not have access to this product.']);
        }

        // Generate unique activation number
        do {
            $activationNumber = strtoupper(Str::random(16));
        } while (Card::where('activation_number', $activationNumber)->exists());

        $data = [
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'activation_number' => $activationNumber,
            'status' => 'active'
        ];

        if ($request->has('pin')) {
            $data['pin'] = $request->pin;
        }

        $card = Card::create($data);

        return redirect()->route('cards.show', $card->id)
            ->with('success', 'Card created successfully.');
    }

    /**
     * Display the specified card.
     *
     * @param  Card  $card
     * @return Response
     */
    public function show(Card $card)
    {
        // Load the relationships
        $card->load(['client', 'product', 'transactions']);
        
        // Check if relationships exist
        if (!$card->client || !$card->product) {
            return redirect()->route('cards.index')
                ->with('error', 'Card data is incomplete. The client or product may have been deleted.');
        }
        
        return view('cards.show', compact('card'));
    }

    /**
     * Cancel the specified card.
     *
     * @param  Card  $card
     * @return Response
     */
    public function cancel(Card $card)
    {
        if ($card->status === 'cancelled') {
            return redirect()->back()
                ->with('error', 'Card is already cancelled.');
        }

        $card->cancel();

        return redirect()->route('cards.show', $card->id)
            ->with('success', 'Card cancelled successfully.');
    }

    /**
     * Remove the specified card from storage.
     *
     * @param  Card  $card
     * @return Response
     */
    public function destroy(Card $card, Request $request)
    {
        $card->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cards.index')
            ->with('success', 'Card deleted successfully.');
    }
}