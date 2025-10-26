<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resident_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resident_id')->unsigned();
            $table->integer('reason_id')->unsigned();
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
            $table->foreign('reason_id')->references('id')->on('reasons');
            $table->unique('resident_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_reasons');
    }
};
