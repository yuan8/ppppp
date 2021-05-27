<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Data extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_post_type')->unsigned();
            $table->bigInteger('id_taxonomy')->unsigned();
            $table->date('data_date')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('perihal')->nullable();
            $table->integer('max_pages')->default(0);
            
            $table->string('path_file')->nullable();
            $table->string('path_file_pages')->nullable();
            $table->bigInteger('id_user');
            $table->bigInteger('id_user_u')->nullable();

            $table->timestamps();

            $table->foreign('id_post_type')
                  ->references('id')->on('post_types')
                  ->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('id_taxonomy')
                  ->references('id')->on('taxonomy')
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
        Schema::dropIfExists('data');

    }
}
