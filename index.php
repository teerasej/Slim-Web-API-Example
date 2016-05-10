<?php
require 'vendor/autoload.php';

$app = new \Slim\App;

// Define CorsSlim for allow cross-platform access
$corsOptions = array(
    "origin" => "*",
    "allowMethods" => array("POST, GET")
    );
$cors = new \CorsSlim\CorsSlim($corsOptions);
$app->add($cors);


// Below is sample routing

$app->get('/', function ( $request,  $response) {
	$response->write("Hi, This is Pon!");
	return $response;
});

$app->get('/hello/{name}', function ( $request,  $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});


$app->post('/sign-in', function($request, $response){
  $response->getBody()->write("POST!");
  return $response;
});


$app->run();
?>
