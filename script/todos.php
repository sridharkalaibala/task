<?php
try {
    require __DIR__.'/../vendor/autoload.php';
    $config = (include 'config/autoload/elasticsearch.global.php');
    $client = Elasticsearch\ClientBuilder::create()
        ->setHosts($config['elasticsearch']['connection_pool']['default']['hosts'])
        ->build();
    for ($i=1; $i<=100; $i++) {
        $date = new DateTime();
        $date->modify("+$i day");
        $doc = [
            'index' => 'todos',
            'type' => 'todo',
            'body' => [
                'userId' => $i,
                'title' => 'This test todo title for Number '.$i,
                'dueOn' => $date->format('Y-m-d'),
                'status' => rand(0, 1) ? 'pending' : 'completed'
            ],
        ];

        $response = $client->index($doc);
        var_dump($response);
    }

} catch(Exception $e) {
    echo "Exception : ".$e->getMessage();
}
die('End : Elastic Search Indexing');
