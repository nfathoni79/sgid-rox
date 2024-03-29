<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\NewOrder;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'number' => 'required|unique:products|numeric|min:1',
            'name' => 'required|max:40',
        ]);

        $product = new Product();
        $product->number = $validated['number'];
        $product->name = $validated['name'];
        $product->save();

        $message = 'Product successfully added';
        return redirect()->route('products.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file_products'));

        $message = 'Product data imported successfully';
        return redirect()->route('products.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    public function get(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validated = $request->validate([
            'number' => [
                'required',
                Rule::unique('products')->ignore($product),
                'numeric',
                'min:1',
            ],
            'name' => 'required|max:40',
        ]);

        $product->number = $validated['number'];
        $product->name = $validated['name'];
        $product->save();

        $message = 'Product successfully updated';
        return redirect()->route('products.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        $message = 'Product successfully deleted';
        return redirect()->route('products.index')->with('success', $message);
    }

    public function wipe()
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        ProductOrder::truncate();
        NewOrder::truncate();
        Schema::enableForeignKeyConstraints();

        $message = 'All product data wiped successfully';
        return redirect()->route('products.index')->with('success', $message);
    }
}
