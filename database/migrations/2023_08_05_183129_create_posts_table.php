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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->boolean('status');

            $table->foreignId('musician_type_id')->nullable();
            $table->foreign('musician_type_id')->references('id')->on('musician_types');

            $table->foreignId('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
