<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the brands.
     *
     * @return Response
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     *
     * @return Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created brand in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'custom_fields' => 'array|max:5'
        ]);

        Brand::create($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified brand.
     *
     * @param  Brand  $brand
     * @return Response
     */
    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified brand.
     *
     * @param  Brand  $brand
     * @return Response
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand in storage.
     *
     * @param  Request  $request
     * @param  Brand  $brand
     * @return Response
     */
    public function update(Request $request, Brand $brand)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'custom_fields' => 'array|max:5'
        ]);

        $brand->update($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Toggle the status of the specified brand.
     *
     * @param  Brand  $brand
     * @return Response
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->status = $brand->status === 'active' ? 'inactive' : 'active';
        $brand->save();

        return redirect()->route('brands.index')
            ->with('success', 'Brand status updated successfully.');
    }

    /**
     * Remove the specified brand from storage.
     *
     * @param  Brand  $brand
     * @return Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}