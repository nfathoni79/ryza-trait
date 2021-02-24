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

Route::get('/items/{item}', 'ItemController@show')->name('api.items.show');

Route::get('/cobapluck', function () {
    return App\Category::pluck('name', 'id');
});

Route::get('/make_categories_js', function () {
    $categories = App\Category::all();
    $string = "";

    $string .= "export default [\n";

    foreach ($categories as $category) {
        $string .= "{\n";
        $string .= "id: " . $category->number . ",\n";
        $string .= "name: '" . $category->name . "',\n";
        $string .= "items: [\n";

        foreach ($category->items as $item) {
            $string .= $item->number . ", ";
        }

        $string .= "\n]\n},\n";
    }

    $string .= "]";

    return "<pre>" . $string . "</pre>";
});

Route::get('/make_items_js', function () {
    $items = App\Item::orderBy('number', 'asc')->get();
    $string = "";

    $string .= "export default [\n";

    foreach ($items as $item) {
        $string .= "{\n";
        $string .= "id: " . $item->number . ",\n";
        $string .= "name: '" . $item->name . "',\n";

        $string .= "categories: [\n";

        foreach ($item->categories as $category) {
            $string .= $category->number . ", ";
        }

        $string .= "\n],\n";

        $string .= "materials: [\n";

        foreach ($item->materials as $material) {
            if ($material->materialable_type == "App\\Category") {
                $string .= $material->materialable->number . ", ";
            } else {
                $string .= ($material->materialable->number + 43) . ", ";
            }
        }

        $string .= "\n],\n";

        $string .= "},\n";
    }

    $string .= "]";

    return "<pre>" . $string . "</pre>";
});

Route::get('/make_materials_js', function () {
    $categories = App\Category::all();
    $string = "";

    $string .= "export default [\n";

    foreach ($categories as $category) {
        $string .= "{\n";
        $string .= "id: " . $category->number . ",\n";
        $string .= "materialableId: " . $category->number . ",\n";
        $string .= "materialableType: 'category',\n";

        $string .= "items: [\n";

        $material = App\Material::where('materialable_type', 'App\\Category')->where('materialable_id', $category->id)->first();

        foreach ($material->items as $item) {
            $string .= $item->number . ", ";
        }

        $string .= "\n],\n},\n";
    }

    $items = App\Item::orderBy('number', 'asc')->get();

    foreach ($items as $item) {
        $string .= "{\n";
        $string .= "id: " . ($item->number + 43) . ",\n";
        $string .= "materialableId: " . $item->number . ",\n";
        $string .= "materialableType: 'item',\n";

        $string .= "items: [\n";

        $material = App\Material::where('materialable_type', 'App\\Item')->where('materialable_id', $item->id)->first();

        foreach ($material->items as $item) {
            $string .= $item->number . ", ";
        }

        $string .= "\n],\n},\n";
    }

    $string .= "]";

    return "<pre>" . $string . "</pre>";
});
