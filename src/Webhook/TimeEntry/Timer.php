<?php


namespace JDecool\Clockify\Webhook\TimeEntry;


use Illuminate\Database\Capsule\Manager as DB;

class Timer
{
    private $time;
    public function __construct($time)
    {
        $this->time = $time;

        $timeEntryId = $this->time['id'];
        $workspaceId = $this->time['workspaceId'];
        $userId = $this->time['userId'];
        $projectId = $this->time['projectId'];
        //Store workspace project Time entry tags
        $tagIds = $this->time['tags'];
        unset($this->time['tags']);
        $this->storeTimeEntryTagIds(
            $workspaceId,
            $userId,
            $projectId,
            $timeEntryId,
            $tagIds
        );
        //Store workspace project Time entry intervals
        $timeInterval = $this->time['timeInterval'];
        unset($this->time['timeInterval']);
        $this->storeTimeEntryInterval(
            $workspaceId,
            $userId,
            $projectId,
            $timeEntryId,
            $timeInterval
        );
        //Store project
        $taskId = $this->time['task']['id'];
        unset($this->time['hourlyRate']);
        unset($this->time['costRate']);
        unset($this->time['project']);
        unset($this->time['task']);
        unset($this->time['user']);
        unset($this->time['tags']);

        $this->storeTimeEntry($this->time, $taskId);
    }

    private function storeTimeEntryTagIds($workspaceId, $userId, $projectId, $timeEntryId, $tagIds)
    {
        if (is_array($tagIds) || is_object($tagIds)) {
            DB::table('time_entry_tags')->where('timeEntryId', $timeEntryId)->delete();
            foreach ($tagIds as $tagId) {
                $data['workspaceId'] = $workspaceId;
                $data['userId'] = $userId;
                $data['projectId'] = $projectId;
                $data['timeEntryId'] = $timeEntryId;
                $data['tagId'] = $tagId['id'];
                DB::table('time_entry_tags')->updateOrInsert(
                    ['timeEntryId' => $timeEntryId, 'tagId' => $tagId['id']],
                    $data
                );
            }
        }
    }
    private function storeTimeEntryInterval($workspaceId, $userId, $projectId, $timeEntryId, $timeInterval)
    {
        if (isset($timeInterval)) {
            $timeInterval['workspaceId'] = $workspaceId;
            $timeInterval['userId'] = $userId;
            $timeInterval['projectId'] = $projectId;
            $timeInterval['timeEntryId'] = $timeEntryId;
            DB::table('time_entry_intervals')->updateOrInsert(
                ['timeEntryId' => $timeEntryId, 'projectId' => $projectId],
                $timeInterval
            );
        }
    }

    private function storeTimeEntry($workspaceProjectTimeEntry, $taskId)
    {
        if (isset($workspaceProjectTimeEntry)) {
            $workspaceProjectTimeEntry['taskId'] = $taskId;
            DB::table('time_entries')->updateOrInsert(
                ['id' => $workspaceProjectTimeEntry['id']],
                $workspaceProjectTimeEntry
            );
        }
    }
}
