<?php

namespace App\Http\Controllers;

use App\Category;
use App\Material;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
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

        $category = new Category();
        $category->number = $request->number;
        $category->name = $request->name;
        $category->save();

        $material = new Material();
        $material->materialable_id = $category->id;
        $material->materialable_type = 'App\Category';
        $material->save();

        return redirect()->route('admin.categories.index')
            ->with('status', 'Created category "' . $category->name . '"');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'number' => 'required|numeric|min:0',
            'name' => 'required',
        ]);

        $category->number = $request->number;
        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('status', 'Updated category "' . $category->name . '"');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        if ($category->items->count() > 0)
        {
            return redirect()->route('admin.categories.index')
                ->with('statusError', 'Cannot delete category, there are items associated with this category');
        }

        if ($category->material)
        {
            if ($category->material->items->count() > 0)
            {
                return redirect()->route('admin.categories.index')
                    ->with('statusError', 'Cannot delete category, this category is used as material of items');
            }

            $category->material->delete();
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category deleted');
    }
}
