<?php

namespace App\Models;

use App\Models\Event;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class Pretix
{
    private $client;

    public function __construct($handler = null)
    {
        if (!$handler) {
            $handler = new CurlHandler();
        }

        $authtoken = config('services.pretix.token');

        $stack = HandlerStack::create($handler);
        $this->client = new Client([
            'base_uri' => 'https://tickets.podstock.de/api/v1/',
            'handler' => $stack,
            'headers' => [
                'Authorization' => "Token $authtoken",
            ],
        ]);
    }

    public function events()
    {
        $url = 'organizers/podstock/events/';

        return $this->request($url);
    }

    public function orders(Event $event)
    {
        $url = "organizers/podstock/events/{$event->slug}/orders/";

        return $this->request($url);
    }

    public function position(Event $event, $id)
    {
        $url = "organizers/podstock/events/{$event->slug}/orderpositions/$id/";

        return $this->request($url);
    }

    public function next($url)
    {
        return $this->request($url);
    }

    private function request($url)
    {
        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody(), true);
    }
}
