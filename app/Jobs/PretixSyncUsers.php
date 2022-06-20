<?php

namespace App\Jobs;

use App\Models\Event;
use App\Mail\MyLogin;
use App\Models\Pretix;
use App\Models\User;
use App\Mail\PretixDuplicate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PretixSyncUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $clienthandler;
    private $authtoken;

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
        $events = Event::all();
        $emails = [];
        foreach ($events as $event) {
            $json = $pretix->orders($event);

            $pagination = false;
            do {
                if ($pagination) {
                    $json = $pretix->next($json['next']);
                }
                foreach ($json['results'] as $order) {
                    foreach ($order['positions'] as $position) {
                        $email = '';
                        $name = $position['attendee_name'];

                        foreach ($position['answers'] as $answer) {
                            if ($answer['question'] == 77) {
                                $email = $answer['answer'];
                            }
                        }

                        $validator = Validator::make(['email' => $email], [
                            'email' => 'required|email'
                        ]);


                        if ($validator->fails()) {
                            continue;
                        }

                        if (in_array($email, $emails)) {
                            Mail::to($order['email'])->queue(new PretixDuplicate($order, $email));
                            continue;
                        }

                        $pretixid = $order['code'] . '-' . $position['id'];
                        $user = User::where(['pretixid' => $pretixid])->first();
                        if (!$user) {
                            $user = new User;
                            $user->token = strtolower(Str::random(16));
                            $user->password = Hash::make(Str::random(32));
                            $user->name = $name;
                            $user->pretixid = $pretixid;
                            $user->email = $email;
                            $user->save();
                            Mail::to($email)->queue(new MyLogin($user));
                        }

                        $user->email = $email;
                        $user->save();
                        array_push($emails, $email);
                    }
                }
                $pagination = true;
            } while ($json['next']);
        }
    }
}
