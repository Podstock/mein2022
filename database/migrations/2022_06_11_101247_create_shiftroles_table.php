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
        Schema::create('shiftroles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        DB::table('shiftroles')->insert([
            ['name' => 'Stagemanagement', 'description' => 'Du behältst die Zeiten im Blick und signalisierst den Podcastenden auf der Bühne, dass sie zum Ende kommen müssen und sorgst außerdem dafür, dass die Teilnehmenden des nächsten Slots schon bereit stehen, damit die Umbaupausen nicht zu lang werden'],
            ['name' => 'Tontechnik', 'description' => 'Du achtest auf den guten Ton, Lautstärkeverhältnisse und auf den Stream (und wirst selbstredend vorher liebevoll eingewiesen)'],
            ['name' => 'Moderation', 'description' => 'Du sagst einige wenige einleitende Sätze zum nächsten Podcast und unterstützt ggf. den/die Stagemanager*in beim “Von-der-Bühne-Scheuchen” zu langer Podcasts.'],
            ['name' => 'Video', 'description' => 'An der Kamera sorgst du für das optimale Bild.'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shiftroles');
    }
};
