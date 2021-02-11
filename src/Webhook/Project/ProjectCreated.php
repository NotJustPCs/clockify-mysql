<?php


namespace JDecool\Clockify\Webhook\TimeEntry;

use Illuminate\Database\Capsule\Manager as DB;

class TimeEntry
{
    private $time;
    public function __construct($time)
    {
        $this->time = $time;

        $timeEntryId = $this->time['id'];

        $workspaceId = $this->time['workspaceId'];
        $userId = $this->time['userId'];
        //Store workspace project Time entry tags
        $tagIds = $this->time['tagIds'];
        unset($this->time['tagIds']);
        $this->storeWorkspaceProjectTimeEntryTagIds(
            $workspaceId,
            $userId,
            $this->time['projectId'],
            $timeEntryId,
            $tagIds
        );
        //Store workspace project Time entry intervals
        $timeInterval = $this->time['timeInterval'];
        unset($this->time['timeInterval']);
        $this->storeWorkspaceProjectTimeEntryInterval(
            $workspaceId,
            $userId,
            $this->time['projectId'],
            $timeEntryId,
            $timeInterval
        );
        //Store project
        unset($this->time['hourlyRate']);
        unset($this->time['costRate']);
        unset($this->time['project']);
        unset($this->time['task']);
        unset($this->time['user']);
        unset($this->time['tags']);

        $this->storeWorkspaceProjectTimeEntry($this->time);
    }



    public function storeWorkspaceProjectTimeEntryTagIds($workspaceId, $userId, $projectId, $timeEntryId, $tagIds)
    {
        if (isset($tagIds)) {
            if (is_array($tagIds) || is_object($tagIds)) {
                foreach ($tagIds as $tagId) {
                    if (isset($tagId)) {
                        $data['workspaceId'] = $workspaceId;
                        $data['userId'] = $userId;
                        $data['projectId'] = $projectId;
                        $data['timeEntryId'] = $timeEntryId;
                        $data['tagId'] = $tagId;
                        DB::table('time_entry_tags')->updateOrInsert($data);
                    }
                }
            }
        }
    }
    public function storeWorkspaceProjectTimeEntryInterval($workspaceId, $userId, $projectId, $timeEntryId, $timeInterval)
    {
        if (isset($timeInterval)) {
            $timeInterval['workspaceId'] = $workspaceId;
            $timeInterval['userId'] = $userId;
            $timeInterval['projectId'] = $projectId;
            $timeInterval['timeEntryId'] = $timeEntryId;
            DB::table('time_entry_intervals')->updateOrInsert(
                ['timeEntryId' => $timeEntryId],
                $timeInterval
            );
        }
    }

    public function storeWorkspaceProjectTimeEntry($workspaceProjectTimeEntry)
    {
        if (isset($workspaceProjectTimeEntry)) {
            DB::table('time_entries')->updateOrInsert(
                ['id' => $workspaceProjectTimeEntry['id']],
                $workspaceProjectTimeEntry
            );
        }
    }
}
