<?php

declare(strict_types=1);

namespace JDecool\Clockify\Api\Client;

use JDecool\Clockify\{
    Client as Http,
    Exception\ClockifyException,
    Model\ClientDto
};
use Illuminate\Database\Capsule\Manager as DB;

class Client
{
    private $http;

    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * @return ClientDto[]
     */
    public function clients(string $workspaceId, array $params = []): array
    {
        if (isset($params['name']) && empty($params['name'])) {
            throw new ClockifyException('Invalid "name" parameter');
        }

        if (isset($params['page']) && (!is_int($params['page']) || $params['page'] < 1)) {
            throw new ClockifyException('Invalid "page" parameter');
        }

        if (isset($params['page-size']) && (!is_int($params['page-size']) || $params['page-size'] < 1)) {
            throw new ClockifyException('Invalid "page-size" parameter');
        }
        $clientIds = [];
        $clients = $this->http->get("/workspaces/$workspaceId/clients", $params);

        foreach ($clients as $client) {
            array_push($clientIds, $client['id']);
            //Store workspace Tags
            $this->storeClient($client);
        }
        return $clientIds;
    }

    public function create(string $workspaceId, ClientRequest $request): ClientDto
    {
        $data = $this->http->post("/workspaces/$workspaceId/clients", $request->toArray());

        return ClientDto::fromArray($data);
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
