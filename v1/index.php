<?php
require_once './handlers/application.php';
require_once './handlers/database.php';
require '../vendor/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/*!
 * Application routes
 */

# Get
$app->get('/:route', 'about')->conditions(array('route' => '(|about)'));

# Error pages
$app->notFound(function() {
    parse(404, array('status' => 404));
});

$app->error(function (\Exception $e) use ($app) {
	$response = array();
	$response['status'] = 500;
	$response['message'] = $e->getMessage();

	parse($response['status'], $response);
});

/*!
 * Methods without authentication
 */
function about() {
	parse(200, "API RESTful v1");
}

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