<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Personil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('personil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nrp')->unique();
            $table->string('dik_bang_pers')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->mediumText('pendidikan_umum')->nullable();
            $table->mediumText('pendidikan_bagian_personil')->nullable();
            $table->mediumText('order')->nullable();
            $table->mediumText('ijazah')->nullable();
            $table->bigInteger('id_user_c')->nullable();
            $table->bigInteger('id_user_u')->nullable();

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
        //
        Schema::dropIfExists('personil');


    }
}
