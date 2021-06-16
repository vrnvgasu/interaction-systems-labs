<?php
require_once __DIR__ . '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'password');
$channel = $connection->channel();

$channel->exchange_declare('exchange', 'direct', false, false, false);
$channel->queue_declare('queue_1', false, false, false, false);
$channel->queue_bind('queue_1', 'exchange', 'routing_key');

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    sleep(2);
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

//подписались на нашу очередь $queue_name
$channel->basic_consume(
    'queue_1',
    '',
    false,
    true,
    false,
    false,
    $callback
);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();