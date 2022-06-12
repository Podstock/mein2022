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
        Schema::create('shift_user', function (Blueprint $table) {
            $table->primary(['shift_id', 'user_id']);
            $table->unsignedInteger('shift_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('shiftrole_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('shift_id');
            $table->index('shiftrole_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_user');
    }
};
