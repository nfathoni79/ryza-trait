<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Finder;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Item $startItem = null, Item $finalItem = null)
    {
        //
        set_time_limit(3000);

        $title = 'Ryza Trait Transfer';

        $navbarItems = [
            ['name' => 'Trait Transfer', 'link' => route('transfer.index'), 'active' => true],
            ['name' => 'Item List', 'link' => route('items.index'), 'active' => false]
        ];

        $items = Item::pluck('name', 'id');
        $itemsWithMaterial = Item::has('materials')->get()->pluck('name', 'id');
        $transferRoutes = null;

        if ($startItem && $finalItem) {
            $display = false;

            $finder = new Finder();
            $finder->findRoutes($startItem, $finalItem, $display);
            $transferRoutes = $finder->transferRoutes;

            if ($display) {
                return '<pre>' . $finder->display . '</pre>';
            }
        }

        return view('home.transfer.index', compact(
            'title', 'navbarItems', 'items', 'itemsWithMaterial', 'transferRoutes', 'startItem', 'finalItem'
        ));
    }

    public function find(Request $request)
    {
        //
        $request->validate([
            'startItem' => 'required',
            'finalItem' => 'required',
        ]);

        $startItem = Item::findOrFail($request->startItem);
        $finalItem = Item::findOrFail($request->finalItem);

        return redirect()->route('transfer.index', [$startItem, $finalItem]);
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
