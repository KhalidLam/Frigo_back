<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFrigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_frigo', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('product_id') ;
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');


                $table->unsignedBigInteger('frigo_id') ;
                $table->foreign('frigo_id')
                    ->references('id')
                    ->on('frigos')
                    ->onDelete('cascade');

            $table->string('stock')->default(0);
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
        Schema::dropIfExists('product_frigo');
    }
}
