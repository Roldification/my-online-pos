<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_store_id_owner');
            $table->unsignedBigInteger('fk_warehouse_id_owned');
            $table->foreign('fk_store_id_owner')->references('id')->on('stores');
            $table->foreign('fk_warehouse_id_owned')->references('id')->on('warehouses');
            $table->boolean('can_sell_from_here')->nullable(false);
            $table->foreignId('users_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_inventory');
    }
};
