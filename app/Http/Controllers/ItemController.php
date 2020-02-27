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
        $items = Item::all();
        $categories = Category::pluck('name', 'id');
        $materials = Material::orderBy('materialable_type', 'asc')->get();

        $material_temps = [];

        foreach ($materials as $material) {
            $material_temps[$material->id] = $material->materialable->name;
        }

        $materials = $material_temps;

        return view('home.index', compact('title', 'items', 'categories', 'materials'));
    }

    public function indexCategory(Category $category)
    {
        //
        $title = 'Items of category "'. $category->name . '"';

        $items = Item::whereHas('categories', function (Builder $query) use ($category) {
            $query->where('categories.id', $category->id);
        })->get();

        $categories = Category::pluck('name', 'id');
        $materials = Material::orderBy('materialable_type', 'asc')->get();

        $material_temps = [];

        foreach ($materials as $material) {
            $material_temps[$material->id] = $material->materialable->name;
        }

        $materials = $material_temps;

        return view('home.index', compact('title', 'items', 'categories', 'materials'));
    }

    public function indexMaterial(Material $material)
    {
        //
        $title = 'Items of material "'. $material->materialable->name . '"';

        $items = Item::whereHas('materials', function (Builder $query) use ($material) {
            $query->where('materials.id', $material->id);
        })->get();

        $categories = Category::pluck('name', 'id');
        $materials = Material::orderBy('materialable_type', 'asc')->get();

        $material_temps = [];

        foreach ($materials as $material) {
            $material_temps[$material->id] = $material->materialable->name;
        }

        $materials = $material_temps;

        return view('home.index', compact('title', 'items', 'categories', 'materials'));
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
        $title = $item->name;

        return view('home.show', compact('title', 'item'));
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
