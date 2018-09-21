<?php
require_once __DIR__ . '/../vendor/autoload.php';

use WhoisApi\EmailVerifier\Builders\ResponseModelBuilder;
use WhoisApi\EmailVerifier\ApiClient;
use WhoisApi\EmailVerifier\Clients\GuzzleClient;
use WhoisApi\EmailVerifier\Exceptions\UnparsableResponseException;
use WhoisApi\EmailVerifier\Exceptions\AccessDeniedException;
use WhoisApi\EmailVerifier\Exceptions\ServerErrorException;
use WhoisApi\EmailVerifier\Exceptions\EmptyResponseException;
use WhoisApi\EmailVerifier\Exceptions\InvalidOrMissingParameterException;
use WhoisApi\EmailVerifier\Exceptions\TooManyRequestsExcpetion;


$httpClient = new GuzzleClient(new \GuzzleHttp\Client());
$builder = new ResponseModelBuilder('');
$client = new ApiClient($httpClient, $builder, getenv('API_KEY'));

try {
    /* Disable SMTP validation */
    $response = $client->get(
        'support@whoisxmlapi.com',
        [
            'validateSMTP',
        ]
    );
    echo 'Email Address: ' . $response->emailAddress . PHP_EOL;
    echo 'Disposable: ' . ($response->disposableCheck ? 'yes' : 'no') . PHP_EOL;
    echo 'SMTP: ' . ($response->smtpCheck ? 'yes' : 'no') . PHP_EOL;
} catch (UnparsableResponseException $exception) {
    echo "Error: couldn't parse server response" . PHP_EOL;
} catch (EmptyResponseException $exception) {
    echo "Error: the response is empty" . PHP_EOL;
} catch (AccessDeniedException $exception) {
    echo "Error: ({$exception->getCode()}) {$exception->getMessage()}"
        . PHP_EOL;
} catch (ServerErrorException $exception) {
    echo "Error: ({$exception->getCode()}) {$exception->getMessage()}"
        . PHP_EOL;
} catch (InvalidOrMissingParameterException $exception) {
    echo "Error: ({$exception->getCode()}) {$exception->getMessage()}"
        . PHP_EOL;
} catch (TooManyRequestsExcpetion $exception) {
    echo "Error: ({$exception->getCode()}) {$exception->getMessage()}"
        . PHP_EOL;
}