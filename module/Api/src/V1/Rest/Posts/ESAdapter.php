<?php

declare(strict_types=1);

namespace Api\V1\Rest\Posts;

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
    /** @var array */
    protected $posts = [];
    /**
     * function __construct
     */
    public function __construct(Client $client, array $params)
    {
        $this->client = $client;
        $this->params = $params;
        $from         = $params['page'] <= 1 ? 0 : ($params['page'] - 1) * $params['limit'];
        $query        = [
            'index' => 'posts',
            'type'  => 'post',
            'from'  => $from,
            'size'  => $params['limit'],
        ];
        if ($params['filter_userId']) {
            $query['body']['query']['bool']['filter'] = ['term' => ['userId' => $params['filter_userId']]];
        }

        if ($params['filter_title']) {
            $query['body']['query']['bool']['should'][] = ['match_phrase' => ['title' => $params['filter_title']]];
        }

        if ($params['filter_body']) {
            $query['body']['query']['bool']['should'][] = ['match_phrase' => ['body' => $params['filter_body']]];
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
     * function getItems
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
     * function formatFromHits
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
