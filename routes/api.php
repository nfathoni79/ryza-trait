<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('create_item', function () {
    $item = new App\Item();
    $item->name = 'Philosopher Stone';
    $item->save();

    $material = new App\Material();
    $material->materialable_id = $item->id;
    $material->materialable_type = 'App\Item';
    $material->save();

    return $item;
});

Route::get('create_category', function () {
    $category = new App\Category();
    $category->name = 'Elixir';
    $category->save();

    $material = new App\Material();
    $material->materialable_id = $category->id;
    $material->materialable_type = 'App\Category';
    $material->save();

    return $category;
});

Route::get('read_item', function () {
    $items = App\Item::all();

    return $items;
});

Route::get('read_category', function () {
    $categories = App\Category::all();

    return $categories;
});

Route::get('read_material', function () {
    $materials = App\Material::all();

    return $materials;
});

Route::get('delete_all_items', function () {
    $items = App\Item::all();

    foreach ($items as $item)
    {
        $item->delete();
    }

    return $items;
});

Route::get('add_categories', function () {
    $item = App\Item::findOrFail(7);

    $item->categories()->sync([4, 5]);

    return $item->categories;
});

Route::get('add_materials', function () {
    $item = App\Item::findOrFail(7);

    $item->materials()->sync([1, 6]);

    return $item->materials;
});

Route::get('show_item_materials', function () {
    $item = App\Item::findOrFail(7);

    // $materialNames = [];
    //
    // foreach ($item->materials as $material)
    // {
    //     array_push($materialNames, $material->materialable->name);
    // }
    //
    // return $materialNames;

    return $item->materials;
});

Route::get('category_to_material', function () {
    $category = App\Category::findOrFail(3);

    return $category->material;
});

Route::get('material_to_category', function () {
    $material = App\Material::findOrFail(2);

    return $material->materialable;
});
