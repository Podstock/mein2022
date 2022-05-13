<?php

namespace App\Console\Commands;

use App\Mail\Newsletter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NewsletterEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = \App\User::get();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(new Newsletter($user));
        }
    }
}
