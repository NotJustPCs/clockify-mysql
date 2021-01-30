<?php

declare(strict_types=1);

namespace JDecool\Clockify\Api\Task;

use JDecool\Clockify\{
    Client,
    Exception\ClockifyException,
    Model\TaskDto
};
use Illuminate\Database\Capsule\Manager as DB;

class Task
{
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @return TaskDto[]
     */
    public function tasks(string $workspaceId, string $projectId, array $params = []): array
    {
        if (isset($params['is-active']) && !is_bool($params['is-active'])) {
            throw new ClockifyException('Invalid "is-active" parameter (should be a boolean value)');
        }

        if (isset($params['name']) && empty($params['name'])) {
            throw new ClockifyException('Invalid "name" parameter');
        }

        if (isset($params['page']) && (!is_int($params['page']) || $params['page'] < 1)) {
            throw new ClockifyException('Invalid "page" parameter');
        }

        if (isset($params['page-size']) && (!is_int($params['page-size']) || $params['page-size'] < 1)) {
            throw new ClockifyException('Invalid "page-size" parameter');
        }
        $workspaceProjectTasksIds = [];
        $workspaceProjectTasks = $this->http->get("/workspaces/$workspaceId/projects/$projectId/tasks", $params);
        foreach ($workspaceProjectTasks as $workspaceProjectTask) {
            array_push($workspaceProjectTasksIds, $workspaceProjectTask['id']);
            //Store user memberships
            $assigneeIds = $workspaceProjectTask['assigneeIds'];
            unset($workspaceProjectTask['assigneeIds']);
            $this->storeWorkspaceProjectTaskAssigneeIds($workspaceProjectTask['id'], $assigneeIds);
            //Store project
            $this->storeWorkspaceProjectTasks($workspaceId, $projectId, $workspaceProjectTask);
        }
        return $workspaceProjectTasksIds;
    }

    public function create(string $workspaceId, string $projectId, TaskRequest $request): TaskDto
    {
        $data = $this->http->post("/workspaces/$workspaceId/projects/$projectId/tasks", $request->toArray());

        return TaskDto::fromArray($data);
    }

    public function storeWorkspaceProjectTaskAssigneeIds($taskId, $assigneeIds)
    {
        foreach ($assigneeIds as $assigneeId) {
            if (isset($assigneeId)) {
                DB::table('task_assignees')->insert(['taskId' => $taskId, 'assigneeId' => $assigneeId]);
            }
        }
    }

    public function storeWorkspaceProjectTasks($workspaceId, $projectId, $workspaceProjectTask)
    {
        if (isset($workspaceProjectTask)) {
            $workspaceProjectTask['workspaceId'] = $workspaceId;
            $workspaceProjectTask['projectId'] = $projectId;
            DB::table('tasks')->insert($workspaceProjectTask);
        }
    }
}
