<?php
require '../../../vendor/autoload.php';

$config = \Kafka\ConsumerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList('127.0.0.1:9092');
$config->setGroupId('group1');
$config->setBrokerVersion('1.0.0');
$config->setTopics(['test1']);
$consumer = new \Kafka\Consumer();
$consumer->start(function($topic, $part, $message) {
    print_r($message['message']);
});