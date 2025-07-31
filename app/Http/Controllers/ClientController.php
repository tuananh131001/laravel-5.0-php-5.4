<?php

namespace App\Http\Controllers;

use App\Client;
use App\Product;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the clients.
     *
     * @return Response
     */
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     *
     * @return Response
     */
    public function create()
    {
        $products = Product::active()->lists('name', 'id');
        return view('clients.create', compact('products'));
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'password' => 'required|confirmed|min:6',
            'payout_rate' => 'required|numeric|min:0|max:100',
            'products' => 'array|exists:products,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'payout_rate' => $request->payout_rate
        ];

        $client = new Client($data);
        $client->save();

        if ($request->get('products')) {
            $client->products()->sync($request->get('products'));
        }

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     *
     * @param  Client  $client
     * @return Response
     */
    public function show(Client $client)
    {
        $client->load('products', 'cards');
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param  Client  $client
     * @return Response
     */
    public function edit(Client $client)
    {
        $products = Product::active()->lists('name', 'id');
        $selectedProducts = [];
        foreach ($client->products as $product) {
            $selectedProducts[] = $product->id;
        }
        return view('clients.edit', compact('client', 'products', 'selectedProducts'));
    }

    /**
     * Update the specified client in storage.
     *
     * @param  Request  $request
     * @param  Client  $client
     * @return Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clients,email,'.$client->id,
            'password' => 'nullable|confirmed|min:6',
            'payout_rate' => 'required|numeric|min:0|max:100',
            'products' => 'array|exists:products,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'payout_rate' => $request->payout_rate
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $client->update($data);

        if ($request->get('products')) {
            $client->products()->sync($request->get('products'));
        } else {
            $client->products()->detach();
        }

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from storage.
     *
     * @param  Client  $client
     * @return Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}