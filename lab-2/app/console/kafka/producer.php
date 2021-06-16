<?php
require '../../../vendor/autoload.php';

$config = \Kafka\ProducerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList('127.0.0.1:9092');
$config->setBrokerVersion('1.0.0');
$config->setRequiredAck(1);
$config->setIsAsyn(false);
$config->setProduceInterval(500);
$producer = new \Kafka\Producer();

for($i = 0; $i < 2; $i++) {
    $producer->send([
        [
            'topic' => 'test1',
            'value' => 'Shitikov Dmitrii send message: ' . $i,
        ],
    ]);
}