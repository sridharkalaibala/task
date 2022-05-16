<?php

declare(strict_types=1);

namespace Api\V1\Rest\Posts;

use Laminas\ServiceManager\ServiceManager;

class PostsResourceFactory
{
    /**
     * function __invoke
     */
    public function __invoke(ServiceManager $services): PostsResource
    {
        return new PostsResource($services);
    }
}
