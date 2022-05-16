<?php

declare(strict_types=1);

namespace Api\V1\Rest\Todos;

use Elasticsearch\Client;

class TodosMapper
{
    /** @var Client */
    protected $client;

    /**
     * function __construct
     *
     * @param Client $client
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * function fetchAll
     */
    public function fetchAll(array $params = []): TodosCollection
    {
        $params['index'] = 'todos';
        $params['page']  = $params['page'] ?? 1;
        $params['limit'] = isset($params['limit']) && $params['limit'] <= 1000 ? $params['limit'] : 10;
        $adapter         = new ESAdapter($this->client, $params);
        $collection      = new TodosCollection($adapter);
        $collection->setCurrentPageNumber($params['page']);
        $collection->setItemCountPerPage($params['limit']);

        return $collection;
    }
}
