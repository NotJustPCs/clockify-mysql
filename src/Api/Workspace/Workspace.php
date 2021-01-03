<?php

declare(strict_types=1);

namespace JDecool\Clockify\Api\Workspace;

use JDecool\Clockify\{
    Client,
    Model\WorkspaceDto
};
use Illuminate\Database\Capsule\Manager as DB;

class Workspace
{
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @return array
     */
    public function workspaces(): array
    {
        $workSpaceIds = [];
        $workSpaces =  $this->http->get('/workspaces');
        foreach ($workSpaces as $workSpace) {
            $workSpaceId = $workSpace['id'];
            array_push($workSpaceIds, $workSpaceId);
            //Store hourly Rate of workspace
            $hourlyRate = $workSpace['hourlyRate'];
            unset($workSpace['hourlyRate']);
            $this->storeHourlyRate($workSpaceId, $hourlyRate);
            //Store workspace memberships
            $memberships = $workSpace['memberships'];
            unset($workSpace['memberships']);
            $this->storeMemberShips($workSpaceId, $memberships);
            //Store work space Settings
            $workspaceSettings = $workSpace['workspaceSettings'];
            unset($workSpace['workspaceSettings']);
            $this->storeWorkSpaceSettings($workSpaceId, $workspaceSettings);
            //Store Workspace
            $this->storeWorkSpace($workSpace);
        }
        return $workSpaceIds;
    }

    public function create(WorkspaceRequest $request): WorkspaceDto
    {
        $data = $this->http->post('/workspaces', $request->toArray());

        return WorkspaceDto::fromArray($data);
    }

    /**
     * @param $workSpaceId
     * @param $hourlyRate
     */
    public function storeHourlyRate($workSpaceId, $hourlyRate)
    {
        if (isset($hourlyRate)) {
            $hourlyRate['workspaceId'] = $workSpaceId;
            DB::table('clockify_workspace_hourly_rates')->insert($hourlyRate);
        }
    }

    /**
     * @param $workSpaceId
     * @param $memberships
     */
    public function storeMemberShips($workSpaceId, $memberships)
    {
        foreach ($memberships as $membership) {
            if (isset($membership)) {
                $membership['workspaceId'] = $workSpaceId;
                //
                $membershipHourlyRate = $membership['hourlyRate'];
                unset($membership['hourlyRate']);
                $this->storeMemberShipHourlyRate($workSpaceId, $membership['userId'], $membershipHourlyRate);
                DB::table('clockify_workspace_memberships')->insert($membership);
            }
        }
    }

    /**
     * @param $workSpaceId
     * @param $userId
     * @param $membershipHourlyRate
     */
    public function storeMemberShipHourlyRate($workSpaceId, $userId, $membershipHourlyRate)
    {
        if (isset($membershipHourlyRate)) {
            $membershipHourlyRate['workspaceId'] = $workSpaceId;
            $membershipHourlyRate['userId'] = $userId;
            DB::table('clockify_workspace_membership_hourly_rates')->insert($membershipHourlyRate);
        }
    }

    /**
     * @param $workSpaceId
     * @param $workspaceSettings
     */
    public function storeWorkSpaceSettings($workSpaceId, $workspaceSettings)
    {
        if (isset($workspaceSettings)) {
            $workspaceSettings['workspaceId'] = $workSpaceId;
            $workspaceSettingsRound = $workspaceSettings['round'];
            unset($workspaceSettings['round']);
            $this->storeWorkSpaceSettingsRound($workSpaceId, $workspaceSettingsRound);
            //
            $workspaceSettingsAdminOnlyPages = $workspaceSettings['adminOnlyPages'];
            unset($workspaceSettings['adminOnlyPages']);
            $this->storeWorkspaceSettingsAdminOnlyPages($workSpaceId, $workspaceSettingsAdminOnlyPages);
            //
            DB::table('clockify_workspace_settings')->insert($workspaceSettings);
        }
    }

    /**
     * @param $workSpaceId
     * @param $workspaceSettingsRound
     */
    public function storeWorkSpaceSettingsRound($workSpaceId, $workspaceSettingsRound)
    {
        if (isset($workspaceSettingsRound)) {
            $workspaceSettingsRound['workspaceId'] = $workSpaceId;
            DB::table('clockify_workspace_settings_rounds')->insert($workspaceSettingsRound);
        }
    }

    /**
     * @param $workspaceId
     * @param $workspaceSettingsAdminOnlyPages
     */
    public function storeWorkspaceSettingsAdminOnlyPages($workspaceId, $workspaceSettingsAdminOnlyPages)
    {
        foreach ($workspaceSettingsAdminOnlyPages as $page) {
            if (isset($workspaceSettingsAdminOnlyPages)) {
                DB::table('clockify_workspace_admin_only_pages')->insert(['workspaceId' => $workspaceId, 'adminOnlyPages' => $page]);
            }
        }
    }

    /**
     * @param $workSpace
     */
    public function storeWorkSpace($workSpace)
    {
        if (isset($workSpace)) {
            if (!isset($workSpace['featureSubscriptionType'])) {
                $workSpace['featureSubscriptionType'] = null;
            }
            DB::table('clockify_workspaces')->insert($workSpace);
        }
    }
}
