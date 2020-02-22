<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToItemMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_material', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('item_id')->change();
            $table->unsignedBigInteger('material_id')->change();
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('material_id')->references('id')->on('materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_material', function (Blueprint $table) {
            //
            $table->dropForeign('item_material_item_id_foreign');
            $table->dropForeign('item_material_material_id_foreign');
            $table->bigInteger('item_id')->change();
            $table->bigInteger('material_id')->change();
        });
    }
}
