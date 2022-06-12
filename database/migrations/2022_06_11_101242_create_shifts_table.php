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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->integer('duration')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('help_category_id')->nullable();
            $table->boolean('orga')->nullable();
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
        Schema::dropIfExists('shifts');
    }
};
