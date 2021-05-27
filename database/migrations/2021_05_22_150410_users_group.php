<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('user_group_post_type',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_post_type')->unsigned();
            $table->timestamps();

            $table->unique(['id_user','id_post_type']);

            $table->foreign('id_post_type')
                  ->references('id')->on('post_types')
                  ->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('id_user')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('user_group_post_type');

    }
}
