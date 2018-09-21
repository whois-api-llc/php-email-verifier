<?php
require_once __DIR__ . '/../vendor/autoload.php';

use WhoisApi\EmailVerifier\Builders\ClientBuilder;


$builder = new ClientBuilder();

$client = $builder->build(getenv('API_KEY'));

echo $client->getRawData('support@whoisxmlapi.com') . PHP_EOL;

echo print_r($client->get('support@whoisxmlapi.com'), true) . PHP_EOL;