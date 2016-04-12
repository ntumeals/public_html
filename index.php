<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array('templates.path' => './views')
);

define('ROOT_URI', $app->request()->getRootUri().'/');

function get_pages() {
  return array(
    "news" => "最新公告",
    "intro" => "認識膳委會",
    "dietaryinfo" => "本校餐飲廠商資訊",
    "law" => "法規",
    "qa" => "Q&amp;A問答集",
    "meeting" => "會議紀錄及罰款",
    "download" => "下載專區",
    "activity" => "活動花絮",
    "contact" => "聯絡我們",
    "link" => "相關網站",
    "emergency" => "申訴及危急處理"
 );
}

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->get('/dietaryinfo', function() use($app) {
  $app->response()->redirect('dietaryinfo/manage');
  $app->halt(302);
});

$app->get('/dietaryinfo/:type', function($type) use($app) {
  $types = array(
    "manage" => "管理單位",
    "location" => "地點",
    "type" => "餐飲種類"
  );
  if(!isset($types[$type])) {
    echo 'Not Found';
    $app->halt(404);
  }
  $app->render('main.php', array('func' => 'dietaryinfo', 'path' => 'dietaryinfo/'.$type, 'type' => $type, 'title' => '國立臺灣大學膳食協調委員會 - 餐飲業者介紹', 'pages' => get_pages(), 'types' => $types));
});

$app->get('/:path', function($path) use($app) {
  $pages = get_pages();
  if(!isset($pages[$path])) {
    echo 'Not Found';
    $app->halt(404);
  }
  $app->render('main.php', array('func' => 'list', 'path' => $path, 'title' => '國立臺灣大學膳食協調委員會 - '.$pages[$path], 'pages' => $pages));
});

$app->notFound(function() use($app){
  $url = $app->request()->getResourceUri();
  $url = explode('#', $url)[0];
  $url = explode('?', $url)[0];
  $rules = array(
    '/2008/news.html' => 'news',
    '/2008/intro.html' => 'intro',
    '/2008/law'  => 'law',
    '/2008/qa.html' => 'qa',
    '/2008/lecture.html' => 'meeting',
    '/2008/download.html' => 'download',
    '/2008/activity.html' => 'activity',
    '/2008/contact.html' => 'contact',
    '/2008/link.html' => 'link',
    '/2008/emergency.html' => 'emergency',
    '/2008/index.html' => 'news'
  );
  if(isset($rules[$url])) {
    $app->response()->redirect(ROOT_URI.$rules[$url]);
    $app->halt(301);
  }
//  $app->response()->redirect(ROOT_URI.'news');
  echo 'Not Found';
  $app->halt(404);
});

$app->run();

?>
