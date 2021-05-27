<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Category extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('taxonomy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('id_post_type')->unsigned();
            $table->bigInteger('id_user');
            $table->mediumText('description')->nullable();
            $table->timestamps();
             $table->foreign('id_post_type')
                  ->references('id')->on('post_types')
                  ->onDelete('cascade')->onUpdate('cascade');
        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('taxonomy');
        
    }
}
