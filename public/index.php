<?php

use Monolog\Logger;
use JDecool\Clockify\ApiFactory;
use Monolog\Handler\StreamHandler;
use JDecool\Clockify\ClientBuilder;
use JDecool\Clockify\Webhook\Project\ProjectCreated;
use JDecool\Clockify\Webhook\Tag\TagCreated;
use JDecool\Clockify\Webhook\TimeEntry\Timer;
use JDecool\Clockify\Webhook\Task\TaskCreated;
use JDecool\Clockify\Webhook\Client\ClientCreated;
use JDecool\Clockify\Databases\Migrations\Migrations;
use JDecool\Clockify\Webhook\TimeEntry\RemoveTimeEntry;

require __DIR__ . '/../vendor/autoload.php';
$config = parse_ini_file(__DIR__ . '/../config.ini');
// create a log channel
$log = new Logger('Dev');
$log->pushHandler(new StreamHandler(__DIR__ .'/../logger.log', Logger::WARNING));

$builder = new ClientBuilder();
$client = $builder->createClientV1($config['api_key']);

$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$app_url = $config['app_url'];
function timer($log)
{
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    try {
        new Timer($data);
    } catch (\Throwable $th) {
        $log->warning($th);
    }
}
switch ($url) {
    case $app_url . '/my-timer-started':
        timer($log);
        break;
    case $app_url . '/timer-started':
        timer($log);
        break;
    case $app_url . '/my-timer-stopped':
        timer($log);
        break;
    case $app_url . '/timer-stopped':
        timer($log);
        break;
    case $app_url . '/my-time-entry-created-manually':
        timer($log);
        break;
    case $app_url . '/time-entry-created-manually':
        timer($log);
        break;
    case $app_url . '/my-time-entry-updated':
        timer($log);
        break;
    case $app_url . '/time-entry-updated':
        timer($log);
        break;
    case $app_url . '/my-time-entry-deleted':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        try {
            new RemoveTimeEntry($data);
        } catch (\Throwable $th) {
            $log->warning($th);
        }
        break;
    case $app_url . '/time-entry-deleted':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        try {
            new RemoveTimeEntry($data);
        } catch (\Throwable $th) {
            $log->warning($th);
        }
        break;
    case $app_url . '/client-created':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        try {
            new ClientCreated($data);
        } catch (\Throwable $th) {
            $log->warning($th);
        }
        break;
    case $app_url . '/project-created':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        try {
            new ProjectCreated($data);
        } catch (\Throwable $th) {
            $log->warning($th);
        }
        break;
    case $app_url . '/task-created':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        try {
            $log->warning('hmm');
            new TaskCreated($data);
        } catch (\Throwable $th) {
            $log->warning($th);
        }
        break;
    case $app_url . '/tag-created':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        try {
            new TagCreated($data);
        } catch (\Throwable $th) {
            $log->warning($th);
        }
        break;
    case $app_url . '/':
        //Run migrations
        Migrations::execute();
        $params['page-size'] = 5000;
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
            //clients
            $clientApi = $apiFactory->clientApi();
            $clientIds = $clientApi->clients($workspacesId, $params);
        }
        echo 'Data has been fetched successfully';
        break;
    default:
        http_response_code(404);
}
