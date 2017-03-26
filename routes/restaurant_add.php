<?php

$app->get('/admin/restaurant_add', function() use($app) {
  if (!isset($_SESSION['user'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  $db = getDatabaseConnection();
  $stmt = $db->prepare('SELECT * FROM category');
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $cat = [1=> [], 2 => [], 3 => []];
  foreach ($result as $row) {
    $cat[$row['type']][$row['id']] = $row['name'];
  }
  $app->render('main.php', [
    'func' => 'restaurant_add',
    'title' => '新增餐廳',
    'pages' => get_admin_pages(),
    'path' => 'admin/restaurant_add',
    'dietary_location' => $cat[1],
    'dietary_type' => $cat[2],
    'dietary_manage' => $cat[3]
  ]);
});

$app->post('/admin/restaurant_add', function() use($app) {
  if (!isset($_SESSION['user'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  $cols = ['title', 'name', 'location', 'company', 'open', 'tel', 'type', 'description', 'website', 'group_type', 'group_id', 'dietary_type', 'dietary_location', 'dietary_manage', 'disabled'];
  $sql = 'INSERT INTO restaurant ('.implode(', ', $cols).') VALUES (:'.implode(', :', $cols).')';
  $db = getDatabaseConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($_POST);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $id = $db->lastInsertId();
  $_SESSION['flash'] = sprintf('已成功新增 <a href="%srestaurant/%s">%s</a> 餐廳', ROOT_URI, $id, $id);
  $app->response()->redirect('dashboard');
});