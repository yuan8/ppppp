<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class UsersAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

     DB::table('users')->insert([
            'name'=>'admin',
            'email'=>'admin@domain.com',
            'password'=>Hash::make('12345678'),
            // 'api_token'=>Hash::make('admin@domain.com'),
            'role'=>1,
            'jabatan'=>'Admin',
            'pangkat'=>'-',
            'nrp'=>'100000000',
        ]);

        // Schema::table('users',function(Blueprint $table){
        //     $table->string('nrp')->unique();
        //     $table->string('dik_bang_pers')->nullable();
        //     $table->string('pangkat')->nullable();
        //     $table->string('jabatan')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
