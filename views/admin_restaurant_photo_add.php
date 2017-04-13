<form method="POST" multipart="" enctype="multipart/form-data">
<table>
<tbody>
<tr><td>餐廳名稱</td><td><select name="id"><?php
  foreach ($restaurant as $r) {
    echo sprintf('<option value="%s">%s</option>', $r['id'], $r['title']);
  }
?></select></td></tr>
<tr><td>照片</td><td><input name="photos[]" type="file" multiple /></td></tr>
</tbody>
</table>
<input type="submit">
</form>