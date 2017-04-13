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
  $cat = [1=> [0 => ''], 2 => [0 => ''], 3 => [0 => '']];
  foreach ($result as $row) {
    $cat[$row['type']][$row['id']] = $row['name'];
  }
  $stmt = $db->prepare('SELECT id, title FROM restaurant WHERE group_type = 1 AND suspend = 0');
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $groups = [0 => ''];
  foreach ($result as $row) {
    $groups[$row['id']] = $row['title'];
  }
  $app->render('main.php', [
    'func' => 'admin_restaurant_add',
    'title' => '新增餐廳',
    'pages' => get_admin_pages(),
    'path' => 'admin/restaurant_add',
    'dietary_location' => $cat[1],
    'dietary_type' => $cat[2],
    'dietary_manage' => $cat[3],
    'groups' => $groups
  ]);
});

$app->post('/admin/restaurant_add', function() use($app) {
  if (!isset($_SESSION['user'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  $cols = ['title', 'name', 'location', 'company', 'open', 'tel', 'type', 'description', 'website', 'group_type', 'group_id', 'dietary_type', 'dietary_location', 'dietary_manage', 'suspend'];
  $sql = 'INSERT INTO restaurant ('.implode(', ', $cols).') VALUES (:'.implode(', :', $cols).')';
  $db = getDatabaseConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($_POST);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $id = $db->lastInsertId();
  $_SESSION['flash'] = sprintf('已成功新增 <a href="%srestaurant/%s">%s</a> 餐廳', ROOT_URI, $id, $id);
  $app->response()->redirect('dashboard');
});

$app->get('/admin/restaurant_photo_add', function() use($app) {
  if (!isset($_SESSION['user'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  $db = getDatabaseConnection();
  $stmt = $db->prepare('SELECT id, title FROM restaurant WHERE suspend = 0');
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $app->render('main.php', [
    'func' => 'admin_restaurant_photo_add',
    'title' => '新增餐廳照片',
    'pages' => get_admin_pages(),
    'path' => 'admin/restaurant_photo_add',
    'restaurant' => $result
  ]);
});

$app->post('/admin/restaurant_photo_add', function() use($app) {
  if (!isset($_SESSION['user'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  if (!isset($_FILES['photos']) || !isset($_POST['id']) || !$_POST['id']) {
    $app->halt(400);
  }
  $sql = 'INSERT INTO restaurant_image (`restaurant_id`, `path`) VALUES (:id, :path)';
  $db = getDatabaseConnection();
  $stmt = $db->prepare($sql);
  for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {
    $fn = sprintf('uploads/%s_%s_%s.%s', $_POST['id'], time(), $i, strtolower(end(explode('.', $_FILES['photos']['name'][$i]))));
    move_uploaded_file($_FILES['photos']['tmp_name'][$i], 'restaurant/'.$fn);
    $stmt->execute([
      ':id' => $_POST['id'],
      ':path' => $fn
    ]);
  }
  $_SESSION['flash'] = sprintf('已成功上傳照片到 <a href="%srestaurant/%s">%s</a>', ROOT_URI, $_POST['id'], $_POST['id']);
  $app->response()->redirect('dashboard');
});