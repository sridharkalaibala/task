<?php

declare(strict_types=1);

namespace Api\V1\Rest\Todos;

use Elasticsearch\Client;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Stdlib\Parameters;

use function array_merge;

class TodosResource extends AbstractResourceListener
{
    /** @var Client */
    private $client;
    /** @var string */
    private $index = 'todos';
    /** @var string */
    private $type = 'todo';
    /** @var object */
    protected $mapper;
    /** @var object */
    protected $request;

    /**
     * function __construct
     *
     * @param  mixed $services
     */
    public function __construct($services)
    {
        $this->mapper  = $services->get('Api\V1\Rest\Todos\TodosMapper');
        $this->client  = $services->get('elasticsearch.client.default');
        $this->request = $services->get('Request');
        $this->params  = ['index' => $this->index, 'type' => $this->type];
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $this->params['body'] = $data;
        return $this->client->index($this->params);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $this->params['id'] = $id;
        $response           = $this->client->get($this->params);

        return $response['_source'];
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $requestParams = $this->request->getQuery()->toArray();

        return $this->mapper->fetchAll(array_merge($params->toArray(), $requestParams));
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $this->params['id']   = $id;
        $this->params['body'] = ['doc' => $data];

        return $this->client->update($this->params);
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $this->params['id']   = $id;
        $this->params['body'] = ['doc' => $data];
        return $this->client->update($this->params);
    }
}
