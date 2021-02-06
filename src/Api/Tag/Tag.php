<?php

declare(strict_types=1);

namespace JDecool\Clockify\Api\Tag;

use JDecool\Clockify\{
    Client,
    Exception\ClockifyException,
    Model\TagDto
};
use Illuminate\Database\Capsule\Manager as DB;

class Tag
{
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @param string $workspaceId
     * @param array $params
     * @return array
     */
    public function tags(string $workspaceId, array $params = []): array
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

        $tagIds = [];
        $tags = $this->http->get("/workspaces/$workspaceId/tags", $params);
        foreach ($tags as $tag) {
            array_push($tagIds, $tag['id']);
            //Store workspace Tags
            $this->storeTag($tag);
        }
        return $tagIds;
    }

    public function create(string $workspaceId, TagRequest $request): TagDto
    {
        $data = $this->http->post("/workspaces/$workspaceId/tags", $request->toArray());

        return TagDto::fromArray($data);
    }

    /**
     * @param $tag
     */
    public function storeTag($tag)
    {
        if (isset($tag)) {
            DB::table('tags')->insert($tag);
        }
    }
}
