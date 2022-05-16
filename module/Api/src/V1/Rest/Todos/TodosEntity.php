<?php

declare(strict_types=1);

namespace Api\V1\Rest\Todos;

use phpDocumentor\Reflection\Types\Integer;

class TodosEntity
{
    /** @var Integer */
    public $id;
    /** @var Integer */
    public $userId;
    /** @var string */
    public $title;
    /** @var string */
    public $dueOn;
    /** @var string */
    public $status;

    /**
     * getArrayCopy.
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'id'     => $this->id,
            'userId' => $this->userId,
            'title'  => $this->title,
            'dueOn'  => $this->dueOn,
            'status' => $this->status,
        ];
    }

    /**
     * exchangeArray.
     *
     * @param array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        $this->id     = $array['id'];
        $this->userId = $array['userId'];
        $this->title  = $array['title'];
        $this->dueOn  = $array['dueOn'];
        $this->status = $array['status'];
    }
}
