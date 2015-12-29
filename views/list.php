<?php
  $data = json_decode(file_get_contents('data/'.$path.'.json'), 1);
  foreach($data as $section) {
    echo '<h1 class="title"><span>'.$section['title'].'</span></h1>';
    switch($section['type']) {
      case 'list':
        echo '<ul class="list">';
        echo '<li class="first">(請點擊圖示開啟相關附檔/連結)</li>';
        if(isset($section['content'])) {
          foreach($section['content'] as $entry) {
            echo '<li>';
            if(isset($entry['cat'])) {
              echo '<span'. (isset($entry['highlight']) ? ' style="background:red;color:yellow; "' : '') .'>'.$entry['cat'].'</span> ';
            }
            if(isset($entry['date'])) {
              echo $entry['date'].'<br />';
            }
            foreach($entry['files'] as $file) {
              echo $file[0].'&nbsp;<a href="'.$file[1].'"><img class="no" src="'.ROOT_URI.'assets/img/'.$file[2].'.gif" border="0" height="22" width="22" /></a>&nbsp';
            }
            echo '</li>';
          }
        }
        echo '</ul>';
        break;
      case 'plain':
        echo $section['content'];
        break;
    }
    echo '<br><br>';
  }
?>
