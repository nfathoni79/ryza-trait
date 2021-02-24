<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Item List';

        $navbarItems = [
            ['name' => 'Trait Transfer', 'link' => route('transfer.index'), 'active' => false],
            ['name' => 'Item List', 'link' => route('items.index'), 'active' => true]
        ];

        // $items = Item::all();
        $items = Item::orderBy('number', 'asc')->get();

        // NOT WORKING IN DROPDOWN WITHOUT ALL()
        $categories = Category::pluck('name', 'id')->all();
        $materials = Material::orderBy('materialable_type', 'asc')->get()->pluck('materialable.name', 'id')->all();

        return view('home.items.index', compact('title', 'navbarItems', 'items', 'categories', 'materials'));
    }

    public function filter($categoryId = 0, $materialId = 0)
    {
        $title = 'Item List';

        $navbarItems = [
            ['name' => 'Trait Transfer', 'link' => route('transfer.index'), 'active' => false],
            ['name' => 'Item List', 'link' => route('items.index'), 'active' => true]
        ];

        if ($categoryId && $materialId)
        {
            $category = Category::findOrFail($categoryId);
            $material = Material::findOrFail($materialId);

            $controlTitle = 'Items with category "' . $category->name . '" and material "' . $material->materialable->name . '""';

            $items = Item::whereHas('categories', function (Builder $query) use ($category) {
                $query->where('categories.id', $category->id);
            });

            $items = $items->whereHas('materials', function (Builder $query) use ($material) {
                $query->where('materials.id', $material->id);
            });

            $items = $items->orderBy('number', 'asc')->get();
        }
        else if ($categoryId)
        {
            $category = Category::findOrFail($categoryId);
            $controlTitle = 'Items with category "'. $category->name . '"';

            $items = Item::whereHas('categories', function (Builder $query) use ($category) {
                $query->where('categories.id', $category->id);
            })->orderBy('number', 'asc')->get();
        }
        else if ($materialId)
        {
            $material = Material::findOrFail($materialId);
            $controlTitle = 'Items with material "'. $material->materialable->name . '"';

            $items = Item::whereHas('materials', function (Builder $query) use ($material) {
                $query->where('materials.id', $material->id);
            })->orderBy('number', 'asc')->get();
        }
        else
        {
            $controlTitle = 'All Items';
            $items = Item::orderBy('number', 'asc')->get();
        }

        // NOT WORKING IN DROPDOWN WITHOUT ALL()
        $categories = Category::pluck('name', 'id')->all();
        $materials = Material::orderBy('materialable_type', 'asc')->get()->pluck('materialable.name', 'id')->all();

        return view('home.items.index', compact('title', 'navbarItems', 'controlTitle', 'items', 'categories', 'materials'));
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
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
        $item = Item::with('categories', 'materials.materialable')->get()->find($item);

        return $item;
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
    }
}
