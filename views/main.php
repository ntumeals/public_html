<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title><?= getTitle($title) ?></title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <link rel="canonical" href="https://meals.ga.ntu.edu.tw/home/<?= $path ?>" />
  <link href="<?= ROOT_URI ?>assets/default.css" rel="stylesheet" type="text/css" />
  <link href="<?= ROOT_URI ?>assets/default2.css" rel="stylesheet" type="text/css" />

</head><body>
<div id="header">
<div id="logo"></div>
</div>

<hr />
<div id="page">
<div id="sidebar">
<ul>
  <li id="menu">
    <ul>
      <li><a href="<?= ROOT_URI ?>">回首頁</a></li>
<?php
foreach($pages as $key => $title) {
  echo sprintf('<li><a href="%s">%s</a></li>', ROOT_URI.$key, $title);
}
?>
      <li><a href="https://meals.ga.ntu.edu.tw/meals_checksys/index.asp">填報-衛生檢查表</a></li>
      <li><a href="https://meals.ga.ntu.edu.tw/tableware/">填報-餐具檢查</a></li>
    </ul>
  </li>
</ul>
</div>
<div id="content">
  <?php include($func.'.php') ?>
</div>
</div>
<?php include('footer.php') ?>
