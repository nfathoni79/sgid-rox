<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOutletIdProductIdFromProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            //
            $table->dropForeign(['outlet_id']);
            $table->foreign('outlet_id')
                ->references('id')->on('outlets')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dropForeign(['product_id']);
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            //
            $table->dropForeign(['outlet_id']);
            $table->foreign('outlet_id')->references('id')->on('outlets');

            $table->dropForeign(['product_id']);
            $table->foreign('product_id')->references('id')->on('products');
        });
    }
}
