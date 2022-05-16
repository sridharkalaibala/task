<?php

declare(strict_types=1);

namespace Api\V1\Rest\Todos;

use Elasticsearch\Client;
use Laminas\Paginator\Adapter\AdapterInterface;

class ESAdapter implements AdapterInterface
{
    /** @var Client */
    protected $client;
    /** @var array */
    protected $params;
    /** @var array */
    protected $result = [];

    /**
     * function __construct
     */
    public function __construct(Client $client, array $params)
    {
        $this->client = $client;
        $this->params = $params;
        $from         = $params['page'] <= 1 ? 0 : ($params['page'] - 1) * $params['limit'];
        $query        = [
            'index' => 'todos',
            'type'  => 'todo',
            'from'  => $from,
            'size'  => $params['limit'],
        ];
        if ($params['filter_userId']) {
            $query['body']['query']['bool']['filter'] = ['term' => ['userId' => $params['filter_userId']]];
        }

        if ($params['filter_title']) {
            $query['body']['query']['bool']['should'][] = ['match_phrase' => ['title' => $params['filter_title']]];
        }

        if ($params['filter_dueOn']) {
            $query['body']['query']['bool']['should'][] = ['match_phrase' => ['dueOn' => $params['filter_dueOn']]];
        }

        if ($params['filter_status']) {
            $query['body']['query']['bool']['should'][] = ['match' => ['status' => $params['filter_status']]];
        }

        $this->result = $this->client->search($query);

        return $this->result;
    }

    /**
     * count.
     */
    public function count(): int
    {
        return $this->result['hits']['total'];
    }

    /**
     * getItems.
     *
     * @param int $offset
     * @param int $itemCountPerPage
     * @return array
     */
    public function getItems($offset, $itemCountPerPage): array
    {
        return $this->formatFromHits($this->result['hits']['hits']);
    }

    /**
     * formatFromHits.
     *
     * @param array $data
     * @return array
     */
    private function formatFromHits(array $data): array
    {
        $result = [];
        foreach ($data as $value) {
            $value['_source']['id'] = $value['_id'];
            $result[]               = $value['_source'];
        }

        return $result;
    }
}
