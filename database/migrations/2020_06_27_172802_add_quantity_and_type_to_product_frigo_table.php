<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityAndTypeToProductFrigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_frigo', function (Blueprint $table) {
            $table->unsignedBigInteger('quantity')->after('frigo_id')->default(1) ;
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
        Schema::table('product_frigo', function (Blueprint $table) {
            //
        });
    }
}
