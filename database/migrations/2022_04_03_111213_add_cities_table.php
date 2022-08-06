<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {         
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('fa')->nullable();
            $table->string('en')->nullable();
            $table->integer('province_id')->nullable();
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
    }
};
