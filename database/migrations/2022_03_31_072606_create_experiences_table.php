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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads')->cascadeOnDelete();
            $table->string('fa_title')->nullable();
            $table->string('fa_org')->nullable();
            $table->string('fa_reason')->nullable();
            $table->string('fa_start_m')->nullable();
            $table->string('fa_start_y')->nullable();
            $table->string('fa_finish_m')->nullable();
            $table->string('fa_finish_y')->nullable();
            $table->string('en_start_m')->nullable();
            $table->string('en_start_y')->nullable();
            $table->string('en_finish_m')->nullable();
            $table->string('en_finish_y')->nullable();
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
        Schema::dropIfExists('experiences');
    }
};
