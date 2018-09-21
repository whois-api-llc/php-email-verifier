<?php
require_once __DIR__ . '/../vendor/autoload.php';

use WhoisApi\EmailVerifier\Builders\ClientBuilder;


$builder = new ClientBuilder();

$client = $builder->build(getenv('API_KEY'));

echo $client->getRawData('support@whoisxmlapi.com', 'xml');