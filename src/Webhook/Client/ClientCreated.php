<?php


namespace JDecool\Clockify\Webhook\Client;

use Illuminate\Database\Capsule\Manager as DB;


class ClientCreated
{
    private $client;
    public function __construct($client)
    {
        $this->client = $client;
        $this->storeClient($this->client);
    }
    /**
     * @param $client
     */
    public function storeClient($client)
    {
        if (isset($client)) {
            DB::table('clients')->insert($client);
        }
    }
}
