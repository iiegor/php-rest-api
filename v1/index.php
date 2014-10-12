<?php
require '../vendor/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/*!
 * Methods without authentication
 */
$app->get('/', function() use ($app) {
	parse(200, "API RESTful v1");
});

/*!
 * Parse the response to json
 */
function parse($status_code, $response) {
	$app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

/*!
 * Deploy the application
 */
$app->run();