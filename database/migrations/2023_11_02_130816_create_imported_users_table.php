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
        Schema::create('imported_users', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->unsignedTinyInteger('age');

            $table->primary(['first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imported_users');
    }
};
