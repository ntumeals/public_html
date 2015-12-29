<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array('templates.path' => './views')
);

define('ROOT_URI', $app->request()->getRootUri().'/');

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->get('/news', function() use($app) {
  $app->render('main.php', array('path' => 'news'));
});

$app->notFound(function() use($app){
  echo "\n";
  print_r($app->request()->getResourceUri());
//  $app->response()->redirect('/home/');
//  $app->halt(302);
});

$app->run();

?>
