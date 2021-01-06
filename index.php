<?php

use JDecool\Clockify\ApiFactory;
use JDecool\Clockify\ClientBuilder;
use JDecool\Clockify\Databases\Migrations\Migrations;


require __DIR__ . '/vendor/autoload.php';
$config = parse_ini_file('config.ini');

$builder = new ClientBuilder();
$client = $builder->createClientV1($config['api_key']);
//Run migrations
Migrations::execute();
$params['page-size'] = 100000000;
$apiFactory = new ApiFactory($client);
$workspaceApi = $apiFactory->workspaceApi();
$workspacesIds = $workspaceApi->workspaces();
foreach ($workspacesIds as $workspacesId) {
    //tags
    $tagApi = $apiFactory->tagApi();
    $tagIds = $tagApi->tags($workspacesId);
    //projects
    $projectIds = [];
    $projectApi = $apiFactory->projectApi();
    $projectIds = $projectApi->projects($workspacesId, $params);
    //workspace users
    $userApi = $apiFactory->userApi();
    $userIds = $userApi->workspaceUsers($workspacesId);
    //Tasks
    $taskIds = [];
    $taskApi = $apiFactory->taskApi();
    foreach ($projectIds as $projectId) {
        $taskIds = $taskApi->tasks($workspacesId, $projectId, $params);
        //Time entries
        $timeEntryIds = [];
        $timeEntryApi = $apiFactory->timeEntryApi();
        foreach ($userIds as $userId) {
            $params['project'] = $projectId;
            $timeEntryIds = $timeEntryApi->find($workspacesId, $userId, $params);
        }
    }
}
echo 'Data has been fetched successfully';
