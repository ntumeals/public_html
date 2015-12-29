<div id="welcome">
<h1 class="title"><span>歡迎來到</span> 膳食協調委員會網站!</h1>
</div>
<div id="twocols">
<div class="col2">
<h2 class="title">最新公告</h2>
<ul class="list">
  <li class="first">(請點擊圖示開啟相關附檔/連結)</li>
<?php
  $news = json_decode(file_get_contents('data/news.json'), 1);
  foreach($news as $entry) {
    echo '<li><span'. (isset($entry['highlight']) ? ' style="background:red;color:yellow; "' : '') .'>'.$entry['cat'].'</span> '.$entry['date'].'<br />';
    foreach($entry['files'] as $file) {
      echo $file[0].'&nbsp;<a href="'.$file[1].'"><img class="no" src="'.ROOT_URI.'assets/img/'.$file[2].'.gif" border="0" height="22" width="22" /></a>&nbsp';
    }
    echo '</li>';
  }
?>
</ul>
</div>
</div>
