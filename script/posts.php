<?php
try {
    require __DIR__.'/../vendor/autoload.php';
    $config = (include 'config/autoload/elasticsearch.global.php');
    $client = Elasticsearch\ClientBuilder::create()
        ->setHosts($config['elasticsearch']['connection_pool']['default']['hosts'])
        ->build();
    for ($i=1; $i<=100; $i++) {
        $doc = [
            'index' => 'posts',
            'type' => 'post',
            'body' => [
                'userId' => $i,
                'title' => 'This test title for Number '.$i,
                'body' => 'This test body for Number '.$i,
            ],
        ];
        $response = $client->index($doc);
        var_dump($response);
    }

} catch(Exception $e) {
    echo "Exception : ".$e->getMessage();
}
die('End : Elastic Search Indexing');
