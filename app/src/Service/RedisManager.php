<?php

namespace App\Service;

use Predis\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class RedisManager
{
    /** @var Client $client */
    private $client;

    private ParameterBagInterface $bag;

    public function __construct(ParameterBagInterface $bag)
    {
        $this->client = new Client([
            'host'   => $bag->get('app.redis.host'),
        ]);
        $this->connect();
    }

    /**
     * Connect to redis instances
     */
    private function connect() : void
    {
        if (!$this->client->isConnected()) {
            $this->client->connect();
        }
    }

    /**
     * Get The redis client
     */
    public function client() : Client
    {
        return $this->client;
    }

}