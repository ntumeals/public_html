<div id="welcome">
<h1 class="title"><span>餐飲業者介紹</span></h1>
<?php
  $type_html = array();
  foreach($types as $key => $type) {
    $type_html[] = sprintf('<a href="%s">按照%s區分</a>', $key, $type[0]);
  }
  echo implode(" | ", $type_html);
?>
<br />
<a target="_blank" href="http://map.ntu.edu.tw/"> 臺灣大學地圖資訊</a><br />
<br />
</div>
<div class="twocols">
<div class="">
<?php
  foreach($data as $section) {
    echo '<ul class="list2">';
    echo sprintf('<li class="first"><h2 class="title">%s</h2></li><li class="first">%s</li>', $section['name'], $section['other']);
    echo '<li><br></li>';
    foreach($section['items'] as $entry) {
      echo sprintf('<li><a href="%s">%s</a></li>', $entry['id'], $entry['title']);
    }
    echo '</ul><p>&nbsp;</p><p>&nbsp;</p>';
  }
?>
   </div>
   </div>
