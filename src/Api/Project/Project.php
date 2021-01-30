<?php

declare(strict_types=1);

namespace JDecool\Clockify\Api\Project;

use JDecool\Clockify\{
    Client,
    Exception\ClockifyException,
    Model\ProjectDtoImpl
};
use Illuminate\Database\Capsule\Manager as DB;

class Project
{
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @return array
     */
    public function projects(string $workspaceId, array $params = []): array
    {
        if (isset($params['name']) && empty($params['name'])) {
            throw new ClockifyException('Invalid "name" parameter');
        }

        if (isset($params['page']) && (!is_int($params['page']) || $params['page'] < 1)) {
            throw new ClockifyException('Invalid "page" parameter');
        }

        if (isset($params['page-size']) && (!is_int($params['page-size']) || $params['page-size'] < 1)) {
            throw new ClockifyException('Invalid "page-size" parameter');
        }
        $projectIds = [];
        $projects =   $this->http->get("/workspaces/$workspaceId/projects", $params);
        foreach ($projects as $project) {
            array_push($projectIds, $project['id']);
            //Store hourly Rate of project
            $hourlyRate = $project['hourlyRate'];
            unset($project['hourlyRate']);
            $this->storeHourlyRate($project['id'], $hourlyRate);
            //Store project memberships
            $memberships = $project['memberships'];
            unset($project['memberships']);
            $this->storeMemberShips($project['id'], $memberships);
            //Store project estimate
            $estimate = $project['estimate'];
            unset($project['estimate']);
            $this->storeEstimate($project['id'], $estimate);
            //Store project time estimate
            $timeEstimate = $project['timeEstimate'];
            unset($project['timeEstimate']);
            $this->storeTimeEstimate($project['id'], $timeEstimate);
            //Store project cost rate
            $costRate = $project['costRate'];
            unset($project['costRate']);
            $this->storeCostRate($project['id'], $costRate);
            //Store project
            $this->storeProject($project);
        }
        return $projectIds;
    }

    public function create(string $workspaceId, ProjectRequest $request): ProjectDtoImpl
    {
        $data = $this->http->post(" /workspaces/$workspaceId/projects", $request->toArray());

        return ProjectDtoImpl::fromArray($data);
    }

    public function delete(string $workspaceId, string $projectId): void
    {
        $this->http->delete("/workspaces/$workspaceId/projects/$projectId");
    }

    /**
     * @param $projectId
     * @param $hourlyRate
     */
    public function storeHourlyRate($projectId, $hourlyRate)
    {
        if (isset($hourlyRate)) {
            $hourlyRate['projectId'] = $projectId;
            DB::table('project_hourly_rates')->insert($hourlyRate);
        }
    }

    /**
     * @param $projectId
     * @param $memberships
     */
    public function storeMemberShips($projectId, $memberships)
    {
        foreach ($memberships as $membership) {
            if (isset($membership)) {
                $membership['projectId'] = $projectId;
                //
                $membershipHourlyRate = $membership['hourlyRate'];
                unset($membership['hourlyRate']);
                $this->storeMemberShipHourlyRate($projectId, $membership['userId'], $membershipHourlyRate);
                DB::table('project_memberships')->insert($membership);
            }
        }
    }

    /**
     * @param $projectId
     * @param $userId
     * @param $membershipHourlyRate
     */
    public function storeMemberShipHourlyRate($projectId, $userId, $membershipHourlyRate)
    {
        if (isset($membershipHourlyRate)) {
            $membershipHourlyRate['projectId'] = $projectId;
            $membershipHourlyRate['userId'] = $userId;
            DB::table('project_membership_hourly_rates')->insert($membershipHourlyRate);
        }
    }

    /**
     * @param $projectId
     * @param $estimate
     */
    public function storeEstimate($projectId, $estimate)
    {
        if (isset($estimate)) {
            $estimate['projectId'] = $projectId;
            DB::table('project_estimates')->insert($estimate);
        }
    }

    /**
     * @param $projectId
     * @param $timeEstimate
     */
    public function storeTimeEstimate($projectId, $timeEstimate)
    {
        if (isset($timeEstimate)) {
            $timeEstimate['projectId'] = $projectId;
            DB::table('project_time_estimates')->insert($timeEstimate);
        }
    }

    /**
     * @param $projectId
     * @param $timeEstimate
     */
    public function storeCostRate($projectId, $costRate)
    {
        if (isset($costRate)) {
            $costRate['projectId'] = $projectId;
            DB::table('project_cost_rate')->insert($costRate);
        }
    }

    /**
     * @param $project
     */
    public function storeProject($project)
    {
        if (isset($project)) {
            DB::table('projects')->insert($project);
        }
    }
}
