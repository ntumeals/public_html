<div id="welcome">
<h1 class="title"><span>餐飲業者介紹</span></h1>
<?php
  $type_html = array();
  foreach($types as $key => $entry) {
    if($types[$type][1] == $entry[1]) {
      $type_html[] = sprintf('按照%s區分', $entry[0]);
    } else {
      $type_html[] = sprintf('<a href="%s">按照%s區分</a>', $key, $entry[0]);
    }
  }
  echo implode(" | ", $type_html);
?>
<br /><br>
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
      if(isset($entry['id'])) {
        echo sprintf('<li><a href="../restaurant/%s">%s</a></li>', $entry['id'], $entry['title']);
      } else if(isset($entry['link'])) {
        echo sprintf('<li><a target="_blank" href="%s">%s</a></li>', $entry['link'], $entry['title']);
      }
    }
    echo '</ul><p>&nbsp;</p><p>&nbsp;</p>';
  }
?>
   </div>
   </div>
