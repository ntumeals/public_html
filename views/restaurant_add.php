<?php
$form_items = [
  ['連結名稱', 'title'],
  ['餐飲業者名稱', 'name'],
  ['本校營業地點位置', 'location'],
  ['公司名稱', 'company'],
  ['營業時間及休息日', 'open'],
  ['聯絡電話', 'tel'],
  ['營業項目、型態', 'type'],
  ['業者簡介', 'description'],
  ['網站', 'website'],
  ['群組類型', 'group_type', ['無', '廣場本體', '廣場成員']],
  ['群組編號', 'group_id'],
  ['餐飲分類', 'dietary_type', $dietary_type],
  ['地點分類', 'dietary_location', $dietary_location],
  ['管理單位', 'dietary_manage', $dietary_manage],
  ['營業狀況', 'disabled', ['正常', '停業']]
];
?>
<form method="POST">
<table>
<tbody>
<?php
  foreach ($form_items as $item) {
    echo sprintf('<tr><td>%s</td><td>', $item[0]);
    if (count($item) > 2) {
      echo sprintf('<select name="%s">', $item[1]);
      foreach ($item[2] as $key => $label) {
        echo sprintf('<option value="%s">%s</option>', $key, $label);
      }
      echo '</select>';
    } else {
      echo sprintf('<input name="%s">',$item[1]);
    }
    echo '<td></tr>';
  }
?>
</tbody>
</table>
<input type="submit">
</form>