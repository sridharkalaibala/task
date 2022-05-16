<?php

declare(strict_types=1);

use Api\V1\Rest\Posts\PostsCollection;
use Api\V1\Rest\Posts\PostsEntity;
use Api\V1\Rest\Posts\PostsResource;
use Api\V1\Rest\Posts\PostsResourceFactory;
use Api\V1\Rest\Todos\TodosCollection;
use Api\V1\Rest\Todos\TodosEntity;
use Api\V1\Rest\Todos\TodosResource;
use Api\V1\Rest\Todos\TodosResourceFactory;
use Laminas\Filter\HtmlEntities;
use Laminas\Filter\StringTrim;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\I18n\Filter\NumberParse;
use Laminas\I18n\Validator\DateTime;
use Laminas\I18n\Validator\IsInt;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\InArray;
use Laminas\Validator\StringLength;

return [
    'service_manager'               => [
        'factories' => [
            PostsResource::class => PostsResourceFactory::class,
            TodosResource::class => TodosResourceFactory::class,
        ],
    ],
    'router'                        => [
        'routes' => [
            'api.rest.posts' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/posts[/:posts_id]',
                    'defaults' => [
                        'controller' => 'Api\\V1\\Rest\\Posts\\Controller',
                    ],
                ],
            ],
            'api.rest.todos' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/todos[/:todos_id]',
                    'defaults' => [
                        'controller' => 'Api\\V1\\Rest\\Todos\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning'          => [
        'uri' => [
            0 => 'api.rest.posts',
            1 => 'api.rest.todos',
        ],
    ],
    'api-tools-rest'                => [
        'Api\\V1\\Rest\\Posts\\Controller' => [
            'listener'                   => PostsResource::class,
            'route_name'                 => 'api.rest.posts',
            'route_identifier_name'      => 'posts_id',
            'collection_name'            => 'posts',
            'entity_http_methods'        => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
            ],
            'collection_http_methods'    => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size'                  => '10',
            'page_size_param'            => 'limit',
            'entity_class'               => PostsEntity::class,
            'collection_class'           => PostsCollection::class,
            'service_name'               => 'Posts',
        ],
        'Api\\V1\\Rest\\Todos\\Controller' => [
            'listener'                   => TodosResource::class,
            'route_name'                 => 'api.rest.todos',
            'route_identifier_name'      => 'todos_id',
            'collection_name'            => 'todos',
            'entity_http_methods'        => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
            ],
            'collection_http_methods'    => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size'                  => '10',
            'page_size_param'            => null,
            'entity_class'               => TodosEntity::class,
            'collection_class'           => TodosCollection::class,
            'service_name'               => 'Todos',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers'            => [
            'Api\\V1\\Rest\\Posts\\Controller' => 'HalJson',
            'Api\\V1\\Rest\\Todos\\Controller' => 'HalJson',
        ],
        'accept_whitelist'       => [
            'Api\\V1\\Rest\\Posts\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Api\\V1\\Rest\\Todos\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Api\\V1\\Rest\\Posts\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'Api\\V1\\Rest\\Todos\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal'                 => [
        'metadata_map' => [
            PostsEntity::class     => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.posts',
                'route_identifier_name'  => 'posts_id',
                'hydrator'               => ArraySerializableHydrator::class,
            ],
            PostsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.posts',
                'route_identifier_name'  => 'posts_id',
                'is_collection'          => true,
            ],
            TodosEntity::class     => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.todos',
                'route_identifier_name'  => 'todos_id',
                'hydrator'               => ArraySerializableHydrator::class,
            ],
            TodosCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.todos',
                'route_identifier_name'  => 'todos_id',
                'is_collection'          => true,
            ],
        ],
    ],
    'api-tools-content-validation'  => [
        'Api\\V1\\Rest\\Posts\\Controller' => [
            'input_filter' => 'Api\\V1\\Rest\\Posts\\Validator',
        ],
        'Api\\V1\\Rest\\Todos\\Controller' => [
            'input_filter' => 'Api\\V1\\Rest\\Todos\\Validator',
        ],
    ],
    'input_filter_specs'            => [
        'Api\\V1\\Rest\\Posts\\Validator' => [
            0 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => IsInt::class,
                        'options' => [],
                    ],
                    1 => [
                        'name'    => GreaterThan::class,
                        'options' => [
                            'min'     => '0',
                            'message' => 'userId should greater than 0',
                        ],
                    ],
                ],
                'filters'       => [
                    0 => [
                        'name'    => NumberParse::class,
                        'options' => [],
                    ],
                ],
                'name'          => 'userId',
                'description'   => 'Author id of the post',
                'field_type'    => 'integer',
                'error_message' => 'userId field is mandatory and should be valid number',
            ],
            1 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => StringLength::class,
                        'options' => [
                            'min' => '3',
                            'max' => '250',
                        ],
                    ],
                ],
                'filters'       => [
                    0 => [
                        'name'    => StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name'    => HtmlEntities::class,
                        'options' => [],
                    ],
                ],
                'name'          => 'title',
                'description'   => 'Title of the Post',
                'field_type'    => 'string',
                'error_message' => 'Title is mandatory Field. Minimum 3 and maximum 250 length.',
            ],
            2 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => StringLength::class,
                        'options' => [
                            'min'     => '10',
                            'max'     => '2500',
                            'message' => 'Body should be minimum 10 and maximum 2500 length',
                        ],
                    ],
                ],
                'filters'       => [
                    0 => [
                        'name'    => StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name'    => HtmlEntities::class,
                        'options' => [],
                    ],
                ],
                'name'          => 'body',
                'description'   => 'Body of the Post',
                'field_type'    => 'string',
                'error_message' => 'body field is mandatory. Please make sure minimum 10 and maximum 2500 length',
            ],
        ],
        'Api\\V1\\Rest\\Todos\\Validator' => [
            0 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => GreaterThan::class,
                        'options' => [
                            'min' => '0',
                        ],
                    ],
                ],
                'filters'       => [],
                'name'          => 'userId',
                'description'   => 'Today Application user Id',
                'field_type'    => 'integer',
                'error_message' => 'Valid integer and greater than 0',
            ],
            1 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => StringLength::class,
                        'options' => [
                            'min' => '3',
                            'max' => '250',
                        ],
                    ],
                ],
                'filters'       => [
                    0 => [
                        'name'    => StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name'          => 'title',
                'description'   => 'Title of the Todo',
                'field_type'    => 'string',
                'error_message' => 'Valid string min 3 and max 250 length',
            ],
            2 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => DateTime::class,
                        'options' => [
                            'pattern' => 'Y-m-d',
                        ],
                    ],
                ],
                'filters'       => [
                    0 => [
                        'name'    => StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name'          => 'dueOn',
                'description'   => 'Date string for Todo List',
                'field_type'    => 'string',
                'error_message' => 'Validate Date Time String',
            ],
            3 => [
                'required'      => true,
                'validators'    => [
                    0 => [
                        'name'    => InArray::class,
                        'options' => [
                            'haystack' => [
                                0 => 'pending',
                                1 => 'completed',
                            ],
                        ],
                    ],
                ],
                'filters'       => [],
                'name'          => 'status',
                'description'   => 'status value for Todo [pending or completed]',
                'field_type'    => 'string',
                'error_message' => 'Valid value pending or completed',
            ],
        ],
    ],
    'api-tools-mvc-auth'            => [
        'authorization' => [
            'Api\\V1\\Rest\\Posts\\Controller' => [
                'collection' => [
                    'GET'    => false,
                    'POST'   => false,
                    'PUT'    => false,
                    'PATCH'  => false,
                    'DELETE' => false,
                ],
                'entity'     => [
                    'GET'    => false,
                    'POST'   => false,
                    'PUT'    => false,
                    'PATCH'  => false,
                    'DELETE' => false,
                ],
            ],
            'Api\\V1\\Rest\\Todos\\Controller' => [
                'collection' => [
                    'GET'    => false,
                    'POST'   => false,
                    'PUT'    => false,
                    'PATCH'  => false,
                    'DELETE' => false,
                ],
                'entity'     => [
                    'GET'    => false,
                    'POST'   => false,
                    'PUT'    => false,
                    'PATCH'  => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];
