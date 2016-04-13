<?php
$data = json_decode(file_get_contents("restaurant_info.json"), 1);

$rest_img = array();

$item_keys = array("name", "location", "company", "open", "tel", "type", "description", "website");

foreach($data as $rest) {
  $out = array();
  $id = str_replace("-", "", $rest['id']);
  $out[] = $id;
  foreach($item_keys as $key) {
    $out[] = isset($rest['data'][$key]) ? addslashes(str_replace("\r", "\\r", str_replace("\n", "\\n", $rest['data'][$key]))) : '';
  }
  $out[] = $rest['group']['type'];
  if($rest['group']['type'] !== 0) {
    $out[] = abs($rest['group']['id']);
  } else {
    $out[] = "";
  }
  foreach($rest['data']['img'] as $img) {
    $rest_img[] = sprintf('"%s","%s"', $id, $img);
  }
  echo '"'.implode('","', $out).'"'."\n";
}

// echo implode("\n", $rest_img);
