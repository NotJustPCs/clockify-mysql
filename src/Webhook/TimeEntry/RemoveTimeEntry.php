<?php


namespace JDecool\Clockify\Webhook\TimeEntry;

use Illuminate\Database\Capsule\Manager as DB;

class RemoveTimeEntry
{
    private $time;
    public function __construct($time)
    {
        $this->time = $time;
        $timeEntryId = $this->time['id'];

        $this->deleteTimeEntryTagIds($timeEntryId);
        $this->deleteTimeEntryInterval($timeEntryId);
        $this->deleteTimeEntry($timeEntryId);
    }

    private function deleteTimeEntryTagIds($timeEntryId)
    {
        DB::table('time_entry_tags')->where('timeEntryId', $timeEntryId)->delete();
    }

    private function deleteTimeEntryInterval($timeEntryId)
    {
        DB::table('time_entry_intervals')->where('timeEntryId', $timeEntryId)->delete();
    }

    private function deleteTimeEntry($timeEntryId)
    {
        DB::table('time_entries')->where('id', $timeEntryId)->delete();
    }
}
