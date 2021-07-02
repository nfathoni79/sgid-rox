<?php

namespace App\Http\Controllers;

use App\Imports\OutletsImport;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class OutletController extends Controller
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
        return view('outlets.index', compact('outlets'));
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
            'number' => 'required|unique:outlets|numeric|min:1',
            'name' => 'required|max:40',
            'owner' => 'required|max:40',
        ]);

        $outlet = new Outlet();
        $outlet->number = $validated['number'];
        $outlet->name = $validated['name'];
        $outlet->owner = $validated['owner'];
        $outlet->save();

        $message = 'Outlet successfully added';
        return redirect()->route('outlets.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        Excel::import(new OutletsImport, $request->file('file_outlets'));

        $message = 'Outlet data imported successfully';
        return redirect()->route('outlets.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show(Outlet $outlet)
    {
        //
    }

    public function get(Outlet $outlet)
    {
        //
        return $outlet;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function edit(Outlet $outlet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outlet $outlet)
    {
        //
        $validated = $request->validate([
            'number' => [
                'required',
                Rule::unique('outlets')->ignore($outlet),
                'numeric',
                'min:1',
            ],
            'name' => 'required|max:40',
            'owner' => 'required|max:40',
        ]);

        $outlet->number = $validated['number'];
        $outlet->name = $validated['name'];
        $outlet->owner = $validated['owner'];
        $outlet->save();

        $message = 'Outlet successfully updated';
        return redirect()->route('outlets.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outlet $outlet)
    {
        //
        $outlet->delete();

        $message = 'Outlet successfully deleted';
        return redirect()->route('outlets.index')->with('success', $message);
    }

    public function wipe()
    {
        Schema::disableForeignKeyConstraints();
        Outlet::truncate();
        Schema::enableForeignKeyConstraints();

        $message = 'All outlet data wiped successfully';
        return redirect()->route('outlets.index')->with('success', $message);
    }
}
