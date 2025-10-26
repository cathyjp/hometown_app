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
        Schema::create('residents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('family_name');
            $table->string('first_name');
            $table->string('family_name_kana');
            $table->string('first_name_kana');
            $table->string('postal_code', 7);
            $table->string('address_city');
            $table->string('address_detail');
            $table->string('phone', 11);
            $table->char('gender', 1);
            $table->string('birth_date', 6);
            $table->string('email');
            $table->string('status', 1)->default('1');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
