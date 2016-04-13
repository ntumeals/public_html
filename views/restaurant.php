<h1 class="title"><span><?= $data['title'] ?></span></h1>
		<div id="twocols">
			<div class="col2">
				<ul class="list">
					<li class="first"><span>本校營業地點位置</span>&nbsp; <?= $data['location'] ?></li>
					<li><span>餐飲業者名稱</span>&nbsp; <?= $data['name'] ?></li>
					<li><span>公司名稱</span>&nbsp; <?= $data['company'] ?></li>
					<li><span>營業時間及休息日</span>&nbsp; <?= $data['open'] ?></li>
					<li><span>聯絡電話</span>&nbsp; <?= $data['tel'] ?></li>
					<li><span>營業項目、型態</span>&nbsp; <?= $data['type'] ?></li>
					<li><span>業者簡介</span>&nbsp; <br> <?= nl2br($data['description']) ?></li>
				</ul><br />
			</div>
			<div class="col2">
				<h2 class="title">餐廳業者參考照片</h2>
				<ul class="list">
<?php
foreach($images as $image) {
  echo '<li><img src="'.$image.'" class="left" width="370px"/></li>';
}
?>
				</ul>
			</div>
		</div>
	<div style="clear: both;">&nbsp;</div>
