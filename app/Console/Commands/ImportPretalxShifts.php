<?php

namespace App\Console\Commands;

use App\Models\Shift;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportPretalxShifts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pretalx:shifts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Pretalx Shifts';

    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($handler = null)
    {
        parent::__construct();
        if (! $handler) {
            $handler = new CurlHandler();
        }

        $authtoken = config('services.pretalx.token');

        $stack = HandlerStack::create($handler);
        $this->client = new Client([
            'base_uri' => 'https://fahrplan.podstock.de/',
            'handler' => $stack,
            'timeout' => 5.0,
            'headers' => [
                'Authorization' => "Token $authtoken",
            ],
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res = $this->client->request('GET', '/api/events/podstock-2022/submissions?limit=100');

        $json = $res->getBody();

        $submissions_raw = json_decode($json, true);
        $submissions = [];
        foreach ($submissions_raw['results'] as $submission) {
            array_push($submissions, $submission);
        }

        foreach ($submissions as $submission) {
            if ($submission['state'] != 'confirmed') {
                continue;
            }
            if ($submission['submission_type']['de'] == 'Pause') {
                continue;
            }

            $start = Carbon::parse($submission['slot']['start']);
            $end = Carbon::parse($submission['slot']['end']);

            switch ($start->format('d')) {
                case '01':
                    $day = 'day1';
                    break;
                case '02':
                    $day = 'day2';
                    break;
                case '03':
                    $day = 'day3';
                    break;
            }
            $category = 0;
            if ($submission['slot']['room']['de'] == 'Außenbühne') {
                $category = 1;
            }

            if ($submission['slot']['room']['de'] == 'Innenbühne') {
                $category = 2;
            }

            if ($submission['slot']['room']['de'] == 'Podcasttisch') {
                $category = 3;
            }

            if (! $category) {
                continue;
            }

            $shift = new Shift();
            $shift->name = $submission['title'];
            $shift->time = $start->format('H:i');
            $shift->day = $day;
            $shift->help_category_id = $category;
            $shift->duration = $start->diffInMinutes($end);
            $shift->save();

            if ($category == 1) {
                $shift->shiftroles()->attach(1, ['count' => 1]); //Stage
                $shift->shiftroles()->attach(2, ['count' => 1]); //Ton
                $shift->shiftroles()->attach(3, ['count' => 1]); //Moderation
                $shift->shiftroles()->attach(4, ['count' => 2]); //Video
            }
            if ($category == 2) {
                $shift->shiftroles()->attach(2, ['count' => 1]); //Ton
                $shift->shiftroles()->attach(3, ['count' => 1]); //Moderation
                $shift->shiftroles()->attach(4, ['count' => 1]); //Video
            }
            if ($category == 3) {
                $shift->shiftroles()->attach(2, ['count' => 1]); //Ton
            }
        }
    }
}
