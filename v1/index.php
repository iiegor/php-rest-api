<?php
require_once './handlers/application.php';
require_once './handlers/database.php';
require '../vendor/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/*!
 * Application params
 */
$api_key = $user_id = null;

/*!
 * Application routes
 */

# Get
$app->get('/:route', 'showAbout')->conditions(array('route' => '(|about)'));
$app->get('/users/:id', 'authenticate', 'showUsers');

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
function showAbout() {
	parse(200, "API RESTful v1");
}

/*!
 * Methods with authentication
 */
function authenticate() {
	// Get headers
	$headers = apache_request_headers();

	// Get instance
	$app = \Slim\Slim::getInstance();

	$response = array();

	if(isset($headers['Authorization'])) {
		// Validate the api key
		global $user_id;
	}
	else
	{
		$response['status'] = 400;
		$response['message'] = "The api key is missing";

		parse($response['status'], $response);
		$app->stop();
	}
}

function showUsers($id) {
	parse(200, array('id' => $id));
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