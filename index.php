<?php
require 'vendor/autoload.php';
require 'config.php';

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

function getDatabaseConnection() {
  return new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}

function getTitle($str) {
  return $str." - 國立臺灣大學膳食協調委員會";
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
    "location" => array(
      "地點", 1, "dietary_location"
    ),
    "type" => array(
      "餐飲種類", 2, "dietary_type"
    ),
    "manage" => array(
      "管理單位", 3, "dietary_manage"
    ),
  );
  if(!isset($types[$type])) {
    echo 'Not Found';
    $app->halt(404);
  }
  $db = getDatabaseConnection();
  $stmt = $db->prepare("SELECT `id`, `title`,`".$types[$type][2]."` as `category` FROM `restaurant` WHERE `suspend` = 0 AND `".$types[$type][2]."` IN (SELECT `id` FROM `category` WHERE `type` = :type)");
  $stmt->execute(array(
    ":type" => $types[$type][1]
  ));
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt = $db->prepare("SELECT `title`,`link`,`".$types[$type][2]."` as `category` FROM `restaurant_link` WHERE `".$types[$type][2]."` IN (SELECT `id` FROM `category` WHERE `type` = :type)");
  $stmt->execute(array(
    ":type" => $types[$type][1]
  ));
  $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt = $db->prepare("SELECT * FROM `category` WHERE `type` = :type");
  $stmt->execute(array(
    ":type" => $types[$type][1]
  ));
  $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  foreach($cats as $cat) {
    $data[$cat['id']] = array(
      "name" => $cat['name'],
      "other" => $cat['other'],
      "items" => array()
    );
  }
  foreach($result as $row) {
    $data[$row['category']]['items'][] = array(
      "id" => $row['id'],
      "title" => $row['title']
    );
  }
  foreach($links as $row) {
    $data[$row['category']]['items'][] = array(
      "link" => $row['link'],
      "title" => $row['title']
    );
  }
  $app->render('main.php', array('func' => 'dietaryinfo', 'path' => 'dietaryinfo/'.$type, 'type' => $type, 'data' => $data, 'title' => '餐飲業者介紹', 'pages' => get_pages(), 'types' => $types));
});

$app->get('/restaurant/:id', function($id) use($app) {
  $db = getDatabaseConnection();
  $stmt = $db->prepare("SELECT * FROM `restaurant` WHERE `id` = :id");
  $stmt->execute(array(
    ":id" => $id
  ));
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if(empty($result)) {
    echo 'Not Found';
    $app->halt(404);
  }
  $group = array();
  if($result['group_type'] > 0) {
    $stmt = $db->prepare("SELECT `id`, `title` FROM `restaurant` WHERE `suspend` = 0 AND `group_type` = 2 AND `group_id` = :group_id");
    $stmt->execute(array(
      ":group_id" => $result['group_id']
    ));
    $group = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  $stmt = $db->prepare("SELECT `path` FROM `restaurant_image` WHERE `restaurant_id` = :id");
  $stmt->execute(array(
    ":id" => $id
  ));
  $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $app->render('main.php', array('func' => 'restaurant', 'path' => 'restaurant/'.$id, 'data' => $result, 'images' => $images, 'group' => $group, 'title' => $result['title'], 'pages' => get_pages()));
});

$app->get('/:path', function($path) use($app) {
  $pages = get_pages();
  if(!isset($pages[$path])) {
    echo 'Not Found';
    $app->halt(404);
  }
  $app->render('main.php', array('func' => 'list', 'path' => $path, 'title' => $pages[$path], 'pages' => $pages));
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
    '/2008/index.html' => 'news',
    '/2008/dietaryinfo.html' => 'dietaryinfo/manage',
    '/2008/dietaryinfo_index.html' => 'dietaryinfo/manage',
    '/2008/dietaryinfo_type.html' => 'dietaryinfo/type',
    '/2008/dietaryinfo_place.html' => 'dietaryinfo/location'
  );
  if(isset($rules[$url])) {
    $app->response()->redirect(ROOT_URI.$rules[$url]);
    $app->halt(301);
  }
  if(strpos($url, '2008/restaurant_info/images/') !== false) {
    $app->response()->redirect(ROOT_URI.str_replace("/2008/restaurant_info/", "restaurant/", $url));
    $app->halt(301);
  }
  if(strpos($url, '2008/restaurant_info/') !== false) {
    $fn = explode("2008/restaurant_info/", $url)[1];
    $fn = explode("/", $fn);
    if(count($fn) > 1) {
      switch($fn[0]) {
        case "1st%20girls%20dorm":
        case "1st girls dorm":
          $fn = '109'.str_pad($fn[1], 7, "0", STR_PAD_LEFT);
          break;
        case "small%20fu":
        case "small fu":
          $fn = '744'.str_pad($fn[1], 7, "0", STR_PAD_LEFT);
          break;
        default:
          $fn = $fn[1];
      }
    } else {
      $fn = $fn[0];
    }
    $id = abs(str_replace("-", "", explode(".", $fn)[0]));
    $app->response()->redirect(ROOT_URI."restaurant/".$id);
    $app->halt(301);
  }
//  $app->response()->redirect(ROOT_URI.'news');
  echo 'Not Found';
  $app->halt(404);
});

$app->run();

?>
