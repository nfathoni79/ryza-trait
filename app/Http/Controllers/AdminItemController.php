<?php

namespace App\Http\Controllers;

use App\Item;
use App\Material;
use App\Category;
use Illuminate\Http\Request;

class AdminItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::all();

        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.items.create');
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
        $request->validate([
            'number' => 'required|numeric|min:0',
            'name' => 'required',
        ]);

        $item = new Item();
        $item->number = $request->number;
        $item->name = $request->name;
        $item->save();

        $material = new Material();
        $material->materialable_id = $item->id;
        $material->materialable_type = 'App\Item';
        $material->save();

        return redirect()->route('admin.items.index')
            ->with('status', 'Created item "' . $item->name . '"');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
        $categories = Category::pluck('name', 'id');
        $materials = Material::orderBy('materialable_type', 'asc')->get();

        $material_temps = [];

        foreach ($materials as $material) {
            $material_temps[$material->id] = $material->materialable->name;
        }

        $materials = $material_temps;

        return view('admin.items.edit', compact('item', 'categories', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
        $request->validate([
            'number' => 'required|numeric|min:0',
            'name' => 'required',
        ]);

        $item->number = $request->number;
        $item->name = $request->name;
        $item->save();

        if ($request->categories)
        {
            $item->categories()->sync($request->categories);
        }
        else
        {
            $item->categories()->sync([]);
        }

        if ($request->materials)
        {
            $item->materials()->sync($request->materials);
        }
        else
        {
            $item->materials()->sync([]);
        }

        return redirect()->route('admin.items.index')
            ->with('status', 'Updated item "' . $item->name . '"');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
        if ($item->categories->count() > 0)
        {
            return redirect()->route('admin.items.index')
                ->with('statusError', 'Cannot delete item, there are categories associated with this item');
        }

        if ($item->material)
        {
            if ($item->material->items->count() > 0)
            {
                return redirect()->route('admin.items.index')
                    ->with('statusError', 'Cannot delete item, this item is used as material of other items');
            }

            $item->material->delete();
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('status', 'Item deleted');
    }
}
