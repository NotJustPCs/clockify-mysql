<?php

declare(strict_types=1);

namespace JDecool\Clockify\Api\User;

use JDecool\Clockify\{
    Client,
    Model\CurrentUserDto
};
use Illuminate\Database\Capsule\Manager as DB;

class User
{
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function current(): CurrentUserDto
    {
        $data = $this->http->get("/user");

        return CurrentUserDto::fromArray($data);
    }

    /**
     * @param string $workspaceId
     * @return array
     */
    public function workspaceUsers(string $workspaceId): array
    {
        $workspaceUserIds = [];
        $workspaceUsers = $this->http->get("/workspace/$workspaceId/users");
        foreach ($workspaceUsers as $workspaceUser) {
            array_push($workspaceUserIds, $workspaceUser['id']);
            //Store workspace user memberships
            $memberships = $workspaceUser['memberships'];
            unset($workspaceUser['memberships']);
            $this->storeMemberShips($workspaceId, $memberships);

            //Store workspace user settings
            $settings = $workspaceUser['settings'];
            unset($workspaceUser['settings']);
            $this->storeSettings($workspaceId, $workspaceUser['id'], $settings);
            //Store workspace users
            $this->storeWorkspaceUser($workspaceId, $workspaceUser);
        }
        return $workspaceUserIds;
    }

    public function storeMemberShips($workspaceId, $memberships)
    {
        foreach ($memberships as $membership) {
            if (isset($membership)) {
                $membership['workspaceId'] = $workspaceId;
                //
                $membershipHourlyRate = $membership['hourlyRate'];
                unset($membership['hourlyRate']);
                $this->storeMemberShipHourlyRate($workspaceId, $membership['userId'], $membershipHourlyRate);
                DB::table('clockify_workspace_user_memberships')->insert($membership);
            }
        }
    }
    public function storeMemberShipHourlyRate($workspaceId, $userId, $membershipHourlyRate)
    {
        if (isset($membershipHourlyRate)) {
            $membershipHourlyRate['workspaceId'] = $workspaceId;
            $membershipHourlyRate['userId'] = $userId;
            DB::table('clockify_workspace_user_membership_hourly_rates')->insert($membershipHourlyRate);
        }
    }

    public function storeSettings($workSpaceId, $userId, $workspaceSettings)
    {
        if (isset($workspaceSettings)) {
            ////
            $workspaceUserSummaryReportSettings = $workspaceSettings['summaryReportSettings'];
            unset($workspaceSettings['summaryReportSettings']);
            $this->storeWorkspaceUserSummaryReportSettings($workSpaceId, $userId, $workspaceUserSummaryReportSettings);
            //
            $workspaceSettings['workspaceId'] = $workSpaceId;
            $workspaceSettings['userId'] = $userId;
            DB::table('clockify_workspace_user_settings')->insert($workspaceSettings);
        }
    }

    public function storeWorkspaceUserSummaryReportSettings($workSpaceId, $userId, $workspaceUserSummaryReportSettings)
    {
        if (isset($workspaceUserSummaryReportSettings)) {
            $workspaceUserSummaryReportSettings['workspaceId'] = $workSpaceId;
            $workspaceUserSummaryReportSettings['userId'] = $userId;
            DB::table('clockify_workspace_user_setting_summary_report_settings')->insert($workspaceUserSummaryReportSettings);
        }
    }

    public function storeWorkspaceUser($workSpaceId, $workspaceUser)
    {
        if (isset($workspaceUser)) {
            $workspaceUser['workspaceId'] = $workSpaceId;
            DB::table('clockify_workspace_users')->insert($workspaceUser);
        }
    }
}
