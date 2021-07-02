<?php

namespace App\Http\Controllers;

use App\Imports\OrdersImport;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::all();
        $outlets = Outlet::orderBy('number')->get();
        return view('orders.index', compact('orders', 'outlets'));
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
            'date' => 'required',
            'total' => 'required|numeric|min:1000',
        ]);

        $order = new Order();
        $order->outlet_id = $validated['outlet_id'];
        $order->date = $validated['date'];
        $order->total = $validated['total'];
        $order->save();

        $message = 'Order successfully added';
        return redirect()->route('orders.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        Excel::import(new OrdersImport, $request->file('file_orders'));

        $message = 'Order data imported successfully';
        return redirect()->route('orders.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    public function get(Order $order)
    {
        //
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
        $validated = $request->validate([
            'date' => 'required',
            'total' => 'required|numeric|min:1000',
        ]);

        $order->date = $validated['date'];
        $order->total = $validated['total'];
        $order->save();

        $message = 'Order successfully updated';
        return redirect()->route('orders.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();

        $message = 'Order successfully deleted';
        return redirect()->route('orders.index')->with('success', $message);
    }

    public function wipe()
    {
        Schema::disableForeignKeyConstraints();
        Orders::truncate();
        Schema::enableForeignKeyConstraints();

        $message = 'All order data wiped successfully';
        return redirect()->route('orders.index')->with('success', $message);
    }
}
