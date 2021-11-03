<?php

namespace App\Http\Controllers;

use App\Imports\NewOrdersImport;
use App\Models\NewOrder;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NewOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $outlets = Outlet::orderBy('number')->get();
        $orders = DB::table('new_orders')
            ->join('outlets', 'new_orders.outlet_id', '=', 'outlets.id')
            ->select('outlet_id', 'date', 'outlets.number as outlet_number', 'outlets.name as outlet_name')
            ->selectRaw('sum(quantity * price) as total')
            ->groupBy('outlet_id', 'date')
            ->orderBy('date', 'asc')
            ->orderBy('outlet_id', 'asc')
            ->get();

        return view('new-orders.index',compact('outlets', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $method = 'create';
        $outlets = Outlet::orderBy('number')->get();
        $products = Product::orderBy('number')->get();

        return view('new-orders.create', compact('method', 'outlets', 'products'));
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
            'date' => 'required',
            'outlet_id' => 'required',
            'product_ids' => 'required',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:500',
        ]);

        $outlet = Outlet::find($validated['outlet_id']);

        DB::transaction(function () use ($validated, $outlet) {
            for ($i=0; $i < count($validated['product_ids']); $i++) {
                $product = Product::find($validated['product_ids'][$i]);

                $order = new NewOrder();
                $order->outlet()->associate($outlet);
                $order->product()->associate($product);
                $order->date = $validated['date'];
                $order->quantity = $validated['quantities'][$i];
                $order->price = $validated['prices'][$i];
                $order->save();
            }
        });

        $message = 'Order was added successfully';
        return redirect()->route('new-orders.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        Excel::import(new NewOrdersImport, $request->file('file_new_orders'));

        $message = 'Orders data successfully imported';
        return redirect()->route('new-orders.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewOrder  $newOrder
     * @return \Illuminate\Http\Response
     */
    public function show(NewOrder $newOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewOrder  $newOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(NewOrder $newOrder)
    {
        //
    }

    public function editx(Outlet $outlet, $date)
    {
        $method = 'edit';
        $outlets = Outlet::orderBy('number')->get();
        $products = Product::orderBy('number')->get();

        $currentOutlet = $outlet;
        $currentProducts = NewOrder::where('outlet_id', $outlet->id)
            ->where('date', $date)
            ->orderBy('product_id')
            ->get();

        return view('new-orders.create', compact(
            'method', 'outlets', 'products', 'currentOutlet', 'date',
            'currentProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewOrder  $newOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewOrder $newOrder)
    {
        //
    }

    public function updatex(Request $request, Outlet $outlet, $date)
    {
        $validated = $request->validate([
            'product_ids' => 'required',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:0',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:500',
        ]);

        DB::transaction(function () use ($outlet, $date, $validated) {
            NewOrder::where('outlet_id', $outlet->id)
                ->where('date', $date)
                ->delete();

            for ($i=0; $i < count($validated['product_ids']); $i++) {
                $product = Product::find($validated['product_ids'][$i]);

                $order = new NewOrder();
                $order->outlet()->associate($outlet);
                $order->product()->associate($product);
                $order->date = $date;
                $order->quantity = $validated['quantities'][$i];
                $order->price = $validated['prices'][$i];
                $order->save();
            }
        });

        $message = 'Order was updated successfully';
        return redirect()->route('new-orders.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewOrder  $newOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewOrder $newOrder)
    {
        //
    }

    public function destroyx(Outlet $outlet, $date)
    {
        NewOrder::where('outlet_id', $outlet->id)
            ->where('date', $date)
            ->delete();

        $message = 'Order was deleted successfully';
        return redirect()->route('new-orders.index')->with('success', $message);
    }

    public function wipe()
    {
        NewOrder::truncate();

        $message = 'All order data were wiped successfully';
        return redirect()->route('new-orders.index')->with('success', $message);
    }
}
