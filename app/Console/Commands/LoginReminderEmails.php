<?php

namespace App\Console\Commands;

use App\Mail\MyLogin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LoginReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:login-reminder';

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
        $users = \App\Models\User::whereNull('remember_token')->get();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(new MyLogin($user));
        }
    }
}
