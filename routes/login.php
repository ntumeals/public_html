<?php

$app->get('/admin/login', function() use($app) {
  $app->render('main.php', [
    'func' => 'login',
    'title' => '登入',
    'pages' => [],
    'path' => 'admin/login'
  ]);
});

$app->post('/admin/login', function() use($app) {
  if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  $db = getDatabaseConnection();
  $stmt = $db->prepare('SELECT * FROM user WHERE user = :user AND pass = PASSWORD(:pass)');
  $stmt->execute(array(
    ':user' => $_POST['user'],
    ':pass' => $_POST['pass']
  ));
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if (empty($result)) {
    $app->response()->redirect('login');
    $app->halt(302);    
  }
  $_SESSION['user'] = $result['user'];
  $app->response()->redirect('./');
  $app->halt(302);
});
