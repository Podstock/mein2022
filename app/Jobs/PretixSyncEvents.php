<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Pretix;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PretixSyncEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Pretix $pretix)
    {
        $json = $pretix->events();

        foreach ($json['results'] as $result) {
            $event = Event::where('slug', $result['slug'])->first();
            if (! $event) {
                $event = new Event;
            }
            $event->name = $result['name']['de-informal'];
            $event->slug = $result['slug'];
            $event->save();
        }
    }
}
