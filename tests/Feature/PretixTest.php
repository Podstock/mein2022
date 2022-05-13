<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Jobs\PretixSyncEvents;
use App\Jobs\PretixSyncUsers;
use App\Mail\MyLogin;
use App\Mail\PretixDuplicate;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PretixTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pretix_job_can_sync_events()
    {
        $json = file_get_contents(base_path().'/tests/PretixJsons/events.json');
        $json_update = '{                                  
            "count": 1,                                   
            "next": null,                              
            "previous": null,                     
            "results": [                              
                {
                    "name": {
                        "de-informal": "Podstock 2019 - Cooles Event"
                    },
                    "slug": "2019"
                } 
            ]
        }
        ';

        $mock = new MockHandler([
            new Response(200, [], $json),
            new Response(200, [], $json_update),
        ]);

        $handler = HandlerStack::create($mock);
        $job = new PretixSyncEvents();
        $pretix = new \App\Models\Pretix($handler);
        $job->handle($pretix);

        $this->assertDatabaseHas('events', ['name' => 'Podstock 2019', 'slug' => '2019']);

        //Test update event
        $job->handle($pretix);
        $this->assertDatabaseHas('events', ['name' => 'Podstock 2019 - Cooles Event', 'slug' => '2019']);
    }


    /** @test */
    public function pretix_job_can_sync_users()
    {
        $this->withoutExceptionHandling();
        Mail::fake();

        $json = file_get_contents(base_path().'/tests/PretixJsons/order_example.json');
        $json_page2 = file_get_contents(base_path().'/tests/PretixJsons/order_example_page2.json');
        $json_update = file_get_contents(base_path().'/tests/PretixJsons/order_example_update.json');

        $mock = new MockHandler([
            new Response(200, [], $json),
            new Response(200, [], $json_page2),
            new Response(200, [], $json_update),
        ]);
        
        $code = 'ABC12';
        Event::factory()->create();

        $job = new PretixSyncUsers();

        $pretix = new \App\Models\Pretix($mock);

        $job->handle($pretix);
        Mail::assertQueued(MyLogin::class, function ($mail) {
            return $mail->hasTo('podstockiannerin@example.net');
        });

        $this->assertDatabaseHas(
            'users',
            [
                'email' => 'podstockiannerin@example.net',
                'name' => 'Peter',
            ]
        );

        $job->handle($pretix);

        $this->assertDatabaseHas('users', [
            'email' => 'podstockiannerin@example.net',
            'id' => 1,
            'pretixid' => $code.'-23442',
        ]);

        Mail::assertNotSent(PretixDuplicate::class);
    }

    /** @test **/
    public function pretix_job_notify_users_with_duplicate_emails()
    {
        Mail::fake();
        $this->withoutExceptionHandling();
        $json = file_get_contents(base_path().'/tests/PretixJsons/order_duplicate_email_position.json');
    
        $mock = new MockHandler([
            new Response(200, [], $json),
        ]);
    
        Event::factory()->create();
    
        $job = new PretixSyncUsers();
    
        $pretix = new \App\Models\Pretix($mock);
        $job->handle($pretix);
    
        $this->assertDatabaseMissing('users', ['name' => 'Podstockianer']);
    
         Mail::assertSent(PretixDuplicate::class, function ($mail) {
            return $mail->hasTo('tester@example.org');
        });
    }

} 
