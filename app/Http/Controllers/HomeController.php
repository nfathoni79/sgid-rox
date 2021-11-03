<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $outletOrders = NewOrder::select('outlet_id')
            ->selectRaw('sum(quantity * price) as total')
            ->groupBy('outlet_id')
            ->orderByDesc('total');

        $bestOutlet = null;
        if ($outletOrders->exists()) {
            $bestOutlet = $outletOrders->first()->outlet;
        }

        $productOrders = NewOrder::select('product_id')
            ->selectRaw('sum(quantity) as sum_quantity')
            ->groupBy('product_id')
            ->orderByDesc('sum_quantity');

        $bestProduct = null;
        if ($productOrders->exists()) {
            $bestProduct = $productOrders->first()->product;
        }

        $totalOrders = NewOrder::sum(DB::raw('quantity * price'));
        $totalProducts = NewOrder::sum('quantity');

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
