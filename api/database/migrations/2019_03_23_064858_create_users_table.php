<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $collection) {
            $collection->increments('_id');
//            $collection->string('name');
            $collection->string('email')->unique();
//            $collection->string('password');
//            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voido
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
