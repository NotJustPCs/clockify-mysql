<?php


namespace JDecool\Clockify\Webhook\Tag;

use Illuminate\Database\Capsule\Manager as DB;

class TagCreated
{
    private $tag;
    public function __construct($tag)
    {
        $this->tag = $tag;
        $this->storeTag($this->tag);
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
