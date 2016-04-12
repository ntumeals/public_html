<div id="welcome">
<h1 class="title"><span>餐飲業者介紹</span></h1>
<?php
  $type_html = array();
  foreach($types as $key => $type_name) {
    $type_html[] = sprintf('<a href="%s">按照%s區分</a>', $key, $type_name);
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
  $data = json_decode(file_get_contents('data/dietaryinfo/'.$type.'.json'), 1);
  foreach($data as $section) {
    echo '<ul class="list2">';
    foreach($section['info'] as $key => $entry) {
      echo '<li class="first">';
      if($key == 0) {
        echo sprintf('<h2 class="title">%s</h2>', $entry);
      } else {
        echo $entry;
      }
      echo '</li>';
    }
    if(count($section['info']) < 2) {
      echo '<li class="first">&nbsp;</li>';
    }
    echo '<li><br></li>';
    foreach($section['data'] as $entry) {
      echo sprintf('<li><a href="%s">%s</a></li>', $entry[0][0] == 'h' ? $entry[1] : ROOT_URI."restaurant_info/".$entry[1].".html", $entry[0]);
    }
    echo '</ul><p>&nbsp;</p><p>&nbsp;</p>';
  }
?>
   </div>
   </div>
