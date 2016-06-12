<?php
require 'vendor/autoload.php';

$app = new \Slim\App;
$container = $app->getContainer();

// Add monolog to container as a service
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};


// Define CorsSlim for allow cross-platform access
// $corsOptions = array(
//     "origin" => "*",
//     "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
//     "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
// );
// $cors = new \CorsSlim\CorsSlim($corsOptions);
// $app->add($cors);


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


$app->post('/', function($request, $response){
  $response->getBody()->write("POST!");
  return $response;
});

$app->post('/sign-in', function($request, $response){

  $data = $request->getParsedBody();

  // $this->logger->addInfo('POST data: ' . var_dump($data));
  $response->getBody()->write($data['username']);
  return $response;
});


$app->run();
?>
