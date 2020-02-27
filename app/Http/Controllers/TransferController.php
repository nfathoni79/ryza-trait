<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Searcher;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Trait Transfer';
        $items = Item::pluck('name', 'id');

        return view('home.transfer.index', compact('title', 'items'));
    }

    public function search(Request $request)
    {
        //
        set_time_limit(8000000);

        $request->validate([
            'fromItem' => 'required',
            'toItem' => 'required',
        ]);

        $fromItem = Item::findOrFail($request->fromItem);
        $toItem = Item::findOrFail($request->toItem);

        $fullRoutes = Searcher::searchRoutes($fromItem, $toItem);

        return redirect()->route('transfer.index')->with('fullRoutes' , $fullRoutes);
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
