<?php

declare(strict_types=1);

namespace Api\V1\Rest\Todos;

use Laminas\ServiceManager\ServiceManager;

class TodosResourceFactory
{
    /**
     * function __invoke
     */
    public function __invoke(ServiceManager $services): TodosResource
    {
        return new TodosResource($services);
    }
}
