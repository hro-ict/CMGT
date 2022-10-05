<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text("firstname")->nullable();
            $table->text("lastname")->nullable();
            $table->text("username")->nullable();
            $table->text("password")->nullable();
            $table->text("email")->nullable();
            $table->integer("role_id")->nullable();
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
        Schema::dropIfExists('users');
    }
};
