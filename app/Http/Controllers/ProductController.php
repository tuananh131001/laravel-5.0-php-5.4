<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the products.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::with('brand')->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return Response
     */
    public function create()
    {
        $brands = Brand::active()->lists('name', 'id');
        return view('products.create', compact('brands'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'custom_fields' => 'array|max:5'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  Product  $product
     * @return Response
     */
    public function show(Product $product)
    {
        $product->load('brand', 'clients', 'cards');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  Product  $product
     * @return Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::active()->lists('name', 'id');
        return view('products.edit', compact('product', 'brands'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'custom_fields' => 'array|max:5'
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Toggle the status of the specified product.
     *
     * @param  Product  $product
     * @return Response
     */
    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product status updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  Product  $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}