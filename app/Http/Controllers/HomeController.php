<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Order;
use App\Models\ProductOrder;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $outlets = Outlet::all();

        $bestOutlet = Order::selectRaw('outlet_id, sum(total) as sum_total')
            ->groupBy('outlet_id')
            ->orderByDesc('sum_total')
            ->first()
            ->outlet;

        $bestProduct = ProductOrder::selectRaw('product_id, sum(quantity) as sum_quantity')
            ->groupBy('product_id')
            ->orderByDesc('sum_quantity')
            ->first()
            ->product;

        $totalOrders = Order::sum('total');
        $totalProducts = ProductOrder::sum('quantity');

        return view('home.index', compact('outlets', 'bestOutlet', 'bestProduct', 'totalOrders', 'totalProducts'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
}
