<?php


namespace JDecool\Clockify\Databases\Migrations;

use JDecool\Clockify\Databases\Migrations\ProjectEstimates;
use JDecool\Clockify\Databases\Migrations\ProjectHourlyRates;
use JDecool\Clockify\Databases\Migrations\ProjectMembershipHourlyRates;
use JDecool\Clockify\Databases\Migrations\ProjectMemberships;
use JDecool\Clockify\Databases\Migrations\Projects;
use JDecool\Clockify\Databases\Migrations\ProjectTimeEstimates;
use JDecool\Clockify\Databases\Migrations\Tags;
use JDecool\Clockify\Databases\Migrations\TaskAssignees;
use JDecool\Clockify\Databases\Migrations\Tasks;
use JDecool\Clockify\Databases\Migrations\TimeEntries;
use JDecool\Clockify\Databases\Migrations\TimeEntryIntervals;
use JDecool\Clockify\Databases\Migrations\TimeEntryTags;
use JDecool\Clockify\Databases\Migrations\WorkspaceAdminOnlyPages;
use JDecool\Clockify\Databases\Migrations\WorkspaceHourlyRates;
use JDecool\Clockify\Databases\Migrations\WorkspaceMembershipHourlyRates;
use JDecool\Clockify\Databases\Migrations\WorkspaceMemberships;
use JDecool\Clockify\Databases\Migrations\Workspaces;
use JDecool\Clockify\Databases\Migrations\WorkspaceSettings;
use JDecool\Clockify\Databases\Migrations\WorkspaceSettingsRounds;
use JDecool\Clockify\Databases\Migrations\WorkspaceUserMembershipHourlyRates;
use JDecool\Clockify\Databases\Migrations\WorkspaceUserMemberships;
use JDecool\Clockify\Databases\Migrations\WorkspaceUsers;
use JDecool\Clockify\Databases\Migrations\WorkspaceUserSettings;
use JDecool\Clockify\Databases\Migrations\WorkspaceUserSettingSummaryReportSettings;

class Migrations
{
    public static function execute()
    {
        //WorkSpaces
        Workspaces::up();
        WorkspaceSettings::up();
        WorkspaceSettingsRounds::up();
        WorkspaceHourlyRates::up();
        WorkspaceMemberships::up();
        WorkspaceMembershipHourlyRates::up();
        WorkspaceAdminOnlyPages::up();
        //Work Space Users
        WorkspaceUsers::up();
        WorkspaceUserSettings::up();
        WorkspaceUserSettingSummaryReportSettings::up();
        WorkspaceUserMemberships::up();
        WorkspaceUserMembershipHourlyRates::up();
        //Projects
        Projects::up();
        ProjectTimeEstimates::up();
        ProjectMemberships::up();
        ProjectMembershipHourlyRates::up();
        ProjectHourlyRates::up();
        ProjectEstimates::up();
        //Tags
        Tags::up();
        //Tasks
        Tasks::up();
        TaskAssignees::up();
        //Time Entries
        TimeEntries::up();
        TimeEntryIntervals::up();
        TimeEntryTags::up();
    }
}
