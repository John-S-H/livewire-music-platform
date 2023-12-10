<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('musician_type_id')->after('profile_photo_path')->nullable();

            $table->foreign('musician_type_id')
                ->references('id')
                ->on('musician_types');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['musician_type_id']);
            $table->dropColumn('musician_type_id');
        });
    }
};
