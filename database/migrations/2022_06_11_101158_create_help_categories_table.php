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
        Schema::create('help_categories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->timestamps();
        });
        DB::table('help_categories')->insert([
            ['name' => 'Außenbühne'],
            ['name' => 'Innenbühne'],
            ['name' => 'Podcasttisch'],
            ['name' => 'Küche'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help_categories');
    }
};
