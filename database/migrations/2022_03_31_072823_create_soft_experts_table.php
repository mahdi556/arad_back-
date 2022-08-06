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
        Schema::create('soft_experts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads')->cascadeOnDelete();
            $table->string('fa_name')->nullable();
            $table->string('en_name')->nullable();
            $table->string('level')->nullable();
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
        Schema::dropIfExists('soft_experts');
    }
};
