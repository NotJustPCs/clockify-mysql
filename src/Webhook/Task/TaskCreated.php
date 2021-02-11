<?php


namespace JDecool\Clockify\Webhook\Task;

use Illuminate\Database\Capsule\Manager as DB;

class TaskCreated
{
    private $task;
    public function __construct($task)
    {
        $this->task = $task;
        //Store user memberships
        $assigneeIds = $this->task['assigneeIds'];
        unset($this->task['assigneeIds']);
        $this->storeTaskAssigneeIds($this->task['id'], $assigneeIds);
        $this->storeTask($this->task);
    }

    public function storeTaskAssigneeIds($taskId, $assigneeIds)
    {
        if (is_array($assigneeIds) || is_object($assigneeIds)) {
            foreach ($assigneeIds as $assigneeId) {
                if (isset($assigneeId)) {
                    DB::table('task_assignees')->insert(['taskId' => $taskId, 'assigneeId' => $assigneeId]);
                }
            }
        }
    }

    public function storeTask($data)
    {
        if (isset($data)) {
            $task['id'] = $data['id'];
            $task['name'] = $data['name'];
            $task['projectId'] = $data['projectId'];
            $task['assigneeId'] = $data['assigneeId'];
            $task['estimate'] = $data['estimate'];
            $task['status'] = $data['status'];
            $task['workspaceId'] = NULL;
            $task['duration'] = $data['duration'];
            DB::table('tasks')->insert($task);
        }
    }
}
