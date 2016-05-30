<?php 
// echo "OK";

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function($request, $response){

	$result = array('message'=>'Hi, I am Web API.');
	$newResponse = $response->withJson($result);
	// $response->write('Hi, I am Web API.');
	return $newResponse;

});

$app->get('/news', function($request, $response){
	
	$result = array(array('title'=>'A', 'imageUrl'=>'assets/a.jpg', 'content'=>'blah blah blah'),
		array('title'=>'A', 'imageUrl'=>'assets/a.jpg', 'content'=>'blah blah blah'),
		array('title'=>'A', 'imageUrl'=>'assets/a.jpg', 'content'=>'blah blah blah')
		);
	$newResponse = $response->withJson($result);
	return $newResponse;

});

$app->get('/news/amount/{count}',function($request, $response){

	$newsCount = $request->getAttribute('count');

	$result = array('newsCount' => $newsCount);
	$newResponse = $response->withJson($result);
	return $newResponse;

});

$app->post('/news/search/', function($request, $response){

	$keyword = $request->getParam('keyword');

	$result = $array('searchKeyword' => $keyword );
	$newResponse = $response->withJson($result);
	return $newResponse;

});











$app->run();
 ?>