<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToCategoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_item', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('item_id')->change();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_item', function (Blueprint $table) {
            //
            $table->dropForeign('category_item_category_id_foreign');
            $table->dropForeign('category_item_item_id_foreign');
            $table->bigInteger('category_id')->change();
            $table->bigInteger('item_id')->change();
        });
    }
}
