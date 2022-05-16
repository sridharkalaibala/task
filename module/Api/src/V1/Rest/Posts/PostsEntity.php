<?php

declare(strict_types=1);

namespace Api\V1\Rest\Posts;

class PostsEntity
{
    /** @var integer */
    public $id;
    /** @var integer */
    public $userId;
    /** @var string */
    public $title;
    /** @var string */
    public $body;

    /**
     * getArrayCopy.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return ['id' => $this->id, 'userId' => $this->userId, 'title' => $this->title, 'body' => $this->body];
    }

    /**
     * function exchangeArray
     *
     * @param array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        $this->id     = $array['id'];
        $this->userId = $array['userId'];
        $this->title  = $array['title'];
        $this->body   = $array['body'];
    }
}
