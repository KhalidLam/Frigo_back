<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityAndTypeToProductsRecettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_recettes', function (Blueprint $table) {
            $table->unsignedBigInteger('quantity')->after('recette_id')->default(1) ;
            $table->string('type')->after('quantity')->default('Unité') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_recettes', function (Blueprint $table) {
            //
        });
    }
}
