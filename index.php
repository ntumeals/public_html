<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array('templates.path' => './views')
);

define('ROOT_URI', $app->request()->getRootUri().'/');

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->get('/:path', function($path) use($app) {
  $app->render('main.php', array('path' => $path));
});

$app->notFound(function() use($app){
  $url = $app->request()->getResourceUri();
  $url = explode('#', $url)[0];
  $url = explode('?', $url)[0];
  switch($url) {
    case '/2008/news.html':
      $app->response()->redirect(ROOT_URI.'news');
      break;
  }
//  print_r();
//  $app->response()->redirect('/home/');
//  $app->halt(302);
});

$app->run();

?>
