<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

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
        $outletOrders = NewOrder::select('outlet_id')
            ->selectRaw('sum(quantity * price) as total')
            ->groupBy('outlet_id')
            ->orderBy('outlet_id')
            ->get();

        $labels = [];
        $data = [];

        foreach ($outletOrders as $order) {
            array_push($labels, $order->outlet->number);
            array_push($data, (int)$order->total);
        }

        $result = array('labels' => $labels, 'data' =>  $data);

        return response()->json($result);
    }

    public function outlet($id)
    {
        $outletOrders = NewOrder::select('date')
            ->selectRaw('sum(quantity * price) as total')
            ->where('outlet_id', $id)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        foreach ($outletOrders as $order) {
            array_push($labels, $order->date);
            array_push($data, $order->total);
        }

        $result = array('labels' => $labels, 'data' =>  $data);

        return response()->json($result);
    }

    public function productSummary()
    {
        $productOrders = NewOrder::select('product_id')
            ->selectRaw('sum(quantity) as sum_quantity')
            ->groupBy('product_id')
            ->orderBy('product_id')
            ->get();

        $labels = [];
        $data = [];

        foreach ($productOrders as $order) {
            array_push($labels, $order->product->name);
            array_push($data, (int)$order->sum_quantity);
        }

        $result = array('labels' => $labels, 'data' => $data);

        return response()->json($result);
    }

    public function productOutlet($id)
    {
        $productOrders = NewOrder::select('product_id')
            ->selectRaw('sum(quantity) as sum_quantity')
            ->where('outlet_id', $id)
            ->groupBy('product_id')
            ->orderBy('product_id')
            ->get();

        $labels = [];
        $data = [];

        foreach ($productOrders as $order) {
            array_push($labels, $order->product->name);
            array_push($data, $order->sum_quantity);
        }

        $result = array('labels' => $labels, 'data' =>  $data);

        return response()->json($result);
    }
}
