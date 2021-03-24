<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function summary()
    {
        $orders_total = Order::selectRaw('outlet_id, sum(total) as total_all')->groupBy('outlet_id')->get();

        $labels = [];
        $data = [];

        foreach ($orders_total as $order_total) {
            array_push($labels, $order_total->outlet->number);
            array_push($data, (int)$order_total->total_all);
        }

        $result = array('labels' => $labels, 'data' =>  $data);

        return response()->json($result);
    }

    public function outlet($id)
    {
        $orders = Order::where('outlet_id', $id)->orderBy('date')->get();

        $labels = [];
        $data = [];

        foreach ($orders as $order) {
            array_push($labels, $order->date);
            array_push($data, $order->total);
        }

        $result = array('labels' => $labels, 'data' =>  $data);

        return response()->json($result);
    }

    public function productSummary()
    {
        $productOrders_total = ProductOrder::selectRaw('product_id, sum(quantity) as quantity_all')->groupBy('product_id')->get();

        $labels = [];
        $data = [];

        foreach ($productOrders_total as $productOrder_total) {
            array_push($labels, $productOrder_total->product->name);
            array_push($data, (int)$productOrder_total->quantity_all);
        }

        $result = array('labels' => $labels, 'data' => $data);

        return response()->json($result);
    }

    public function productOutlet($id)
    {
        $productOrders = ProductOrder::where('outlet_id', $id)->orderBy('product_id')->get();

        $labels = [];
        $data = [];

        foreach ($productOrders as $productOrder) {
            array_push($labels, $productOrder->product->name);
            array_push($data, $productOrder->quantity);
        }

        $result = array('labels' => $labels, 'data' =>  $data);

        return response()->json($result);
    }
}
