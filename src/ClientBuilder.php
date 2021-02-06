<?php

declare(strict_types=1);

namespace JDecool\Clockify;

use Http\Client\{
    Common\HttpMethodsClient,
    Common\Plugin\AddHostPlugin,
    Common\Plugin\AddPathPlugin,
    Common\Plugin\AuthenticationPlugin,
    Common\Plugin\HeaderSetPlugin,
    Common\PluginClient,
    HttpClient,
};
use Http\Message\Authentication\Header;
use Psr\Http\Message\{
    RequestFactoryInterface,
    StreamFactoryInterface,
    UriFactoryInterface,
};
use Http\Discovery\{
    Psr17FactoryDiscovery,
    Psr18ClientDiscovery,
};
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use RuntimeException;

class ClientBuilder
{
    private const ENDPOINT_V1 = 'https://api.clockify.me/api/v1/';

    private $httpClient;
    private $requestFactory;
    private $uriFactory;
    private $streamFactory;

    public function __construct(
        ?HttpClient $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?UriFactoryInterface $uriFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUriFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function createClientV1(string $apiKey): Client
    {
        return $this->create(self::ENDPOINT_V1, $apiKey);
    }

    public function create(string $endpoint, string $apiKey): Client
    {
        if (false === filter_var($endpoint, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Invalid Clockify endpoint.');
        }

        if ('' === trim($apiKey)) {
            throw new RuntimeException('API token is required.');
        }

        $plugins = [
            new AuthenticationPlugin(
                new Header('X-Api-Key', $apiKey)
            ),
            new AddHostPlugin(
                $this->uriFactory->createUri($endpoint)
            ),
            new AddPathPlugin(
                $this->uriFactory->createUri($endpoint)
            ),
            new HeaderSetPlugin([
                'User-Agent' => 'github.com/jdecool/clockify-api',
                'Content-Type' => 'application/json',
            ]),
        ];

        $http = new HttpMethodsClient(
            new PluginClient($this->httpClient, $plugins),
            $this->requestFactory,
            $this->streamFactory
        );
        $config = parse_ini_file('config.ini');
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => $config['db_driver'],
            'host'      => $config['db_host'],
            'database'  => $config['db_name'],
            'username'  => $config['db_user'],
            'password'  => $config['db_password'],
            'engine'    => $config['db_engine'],
            'charset'   => $config['db_charset'],
            'collation' => $config['db_collation'],
            'prefix'    => $config['db_prefix'],
        ]);
        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        return new Client($http);
    }
}
