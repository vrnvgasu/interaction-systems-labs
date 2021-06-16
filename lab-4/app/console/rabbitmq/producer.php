<?php
require_once __DIR__ . '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    'localhost',
    5672,
    'user',
    'password'
);
$channel = $connection->channel();

$channel->exchange_declare(
    'exchange',
    'direct',
    false,
    false,
    false
);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'exchange', 'routing_key');

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();