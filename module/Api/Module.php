<?php

declare(strict_types=1);

namespace Api;

use Api\V1\Rest\Posts\PostsMapper;
use Api\V1\Rest\Todos\TodosMapper;
use Laminas\ApiTools\Autoloader;
use Laminas\ApiTools\Provider\ApiToolsProviderInterface;

class Module implements ApiToolsProviderInterface
{
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig(): array
    {
        return [
            Autoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                'Api\V1\Rest\Posts\PostsMapper' => function ($sm) {
                    $client = $sm->get('elasticsearch.client.default');
                    return new PostsMapper($client);
                },
                'Api\V1\Rest\Todos\TodosMapper' => function ($sm) {
                    $client = $sm->get('elasticsearch.client.default');
                    return new TodosMapper($client);
                },
            ],
        ];
    }
}
