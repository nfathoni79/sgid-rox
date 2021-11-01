<?php

namespace App\Http\Controllers;

use App\Imports\ProductOrdersImport;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productOrders = ProductOrder::all();
        $outlets = Outlet::orderBy('number')->get();
        $products = Product::orderBy('number')->get();
        return view('product-orders.index', compact('productOrders', 'outlets', 'products'));
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
            'outlet_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:0',
        ]);

        $outlet = Outlet::find($validated['outlet_id']);
        $outlet->products()->syncWithoutDetaching([
            $validated['product_id'] => ['quantity' => $validated['quantity']]
        ]);

        $message = 'Product Order successfully added';
        return redirect()->route('product-orders.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        Excel::import(new ProductOrdersImport, $request->file('file_product_orders'));

        $message = 'Product order data imported successfully';
        return redirect()->route('product-orders.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOrder $productOrder)
    {
        //
    }

    public function get(ProductOrder $productOrder)
    {
        //
        return $productOrder;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductOrder $productOrder)
    {
        //
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);

        if ($request->input('change') == '') {
            $productOrder->quantity = $validated['quantity'];
        } else {
            $productOrder->quantity += $request->input('change');
        }
        $productOrder->save();

        $message = 'Product order successfully updated';
        return redirect()->route('product-orders.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductOrder  $productOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOrder $productOrder)
    {
        //
        $productOrder->delete();

        $message = 'Product order successfully deleted';
        return redirect()->route('product-orders.index')->with('success', $message);
    }

    public function wipe()
    {
        ProductOrder::truncate();

        $message = 'All product order data wiped successfully';
        return redirect()->route('product-orders.index')->with('success', $message);
    }
}
