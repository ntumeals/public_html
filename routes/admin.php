<?php
$app->get('/admin', function() use($app) {
  $app->response()->redirect('admin/dashboard');
});

$app->get('/admin/dashboard', function() use($app) {
  if (!isset($_SESSION['user'])) {
    $app->response()->redirect('login');
    $app->halt(302);
  }
  $app->render('main.php', [
    'func' => 'dashboard',
    'title' => '網站管理',
    'pages' => get_admin_pages(),
    'path' => 'admin/dashboard'
  ]);
});