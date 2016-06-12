<?php

require 'vendor/autoload.php';

$config['displayErrorDetails'] = true;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "root";
$config['db']['dbname'] = "mynews";


$app = new \Slim\App(["settings" => $config]);

// Add CorsSlim
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);
$app->add($cors);


$container = $app->getContainer();
// Add monolog to container as a service
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};



$app->get('/', function ( $request,  $response) {
	$response->write("Hi, This is Pon!");
	return $response;
});

$app->get('/news/A', function ( $request,  $response) {

	$result = array('title' => 'A', 'imageUrl' => 'this url','content'=>'blah blah blah');

	$response = $response->withJson($result);

	// $response->write("Hi, This is Pon!");
	return $response;
});

$app->get('/news', function ( $request,  $response) {

	$result = array(
		array('title' => 'A', 'imageUrl' => 'this url','content'=>'blah blah blah'),
		array('title' => 'B', 'imageUrl' => 'this url','content'=>'blah blah blah'),
		array('title' => 'C', 'imageUrl' => 'this url','content'=>'blah blah blah'));

	$response = $response->withJson($result);

	// $response->write("Hi, This is Pon!");
	return $response;
});

$app->get('/news-test', function ($request, $response) {

	// $resultRows = $this->db->exec('SELECT * FROM news');
	$result = array();
	foreach($this->db->query('SELECT * FROM news') as $row) {
	   array_push($result, $row);
	}

	// $result = array(
	// 	array('title' => 'A', 'imageUrl' => 'this url','content'=>'blah blah blah'),
	// 	array('title' => 'B', 'imageUrl' => 'this url','content'=>'blah blah blah'),
	// 	array('title' => 'C', 'imageUrl' => 'this url','content'=>'blah blah blah'));

	$response = $response->withJson($result);

	// $response->write("Hi, This is Pon!");
	return $response;
});


$app->run();

?>
