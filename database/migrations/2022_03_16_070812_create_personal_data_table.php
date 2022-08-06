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
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->integer('fa_birt_d')->nullable();
            $table->integer('fa_birt_m')->nullable();
            $table->integer('fa_birt_y')->nullable();
            $table->string('fa_province')->nullable();
            $table->string('fa_city')->nullable();
            $table->string('fa_military')->nullable();
            $table->integer('en_birt_d')->nullable();
            $table->integer('en_birt_m')->nullable();
            $table->integer('en_birt_y')->nullable();
            $table->string('en_province')->nullable();
            $table->string('en_city')->nullable();
            $table->string('en_military')->nullable();
            $table->bigInteger('fa_salary_from')->nullable();;
            $table->bigInteger('fa_salary_to')->nullable();
            $table->string('sex')->default('1');
            $table->string('mrarried')->default('1');
            $table->string('insurrance')->default('1');
            
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
        Schema::dropIfExists('personal_data');
    }
};
