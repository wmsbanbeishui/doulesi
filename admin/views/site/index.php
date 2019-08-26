<?php

/**
 * @var $this yii\web\View
 */

use admin\models\AdminMenu;
use common\helpers\Helper;
use yii\helpers\Html;

$menu = AdminMenu::personMenu(Yii::$app->user->id);

/** @var \admin\models\Admin $admin */
$admin = Yii::$app->getUser()->getIdentity();

$avatar = '/static/admin/images/test_icon.png';

$this->title = '记账记事本 - 逗乐思';
$admin_logo = '';
if (strpos($_SERVER['HTTP_HOST'], '.local.')) {
	$this->title .= '【本地版】';
	$admin_logo = '';
}
if (strpos($_SERVER['HTTP_HOST'], '.dev.')) {
	$this->title .= '【开发版】';
	$admin_logo = '';
}
if (strpos($_SERVER['HTTP_HOST'], '.test.')) {
	$this->title .= '【测试版】';
	$admin_logo = '';
}

?>
<!DOCTYPE html>
<html lang="cn" use-rem="1920">

<head>
	<meta charset="UTF-8">
	<title><?= $this->title ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<meta content="telephone=no" name="format-detection"/>
	<link rel="stylesheet" type="text/css" href="/static/admin/css/lib/reset.css"/>
	<link rel="stylesheet" type="text/css" href="/static/admin/css/index.css"/>
	<script src="/static/admin/js/jquery/2.2.4/jquery.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>

<!--顶部导航，可以封装成公共部分-->
<div class="top-nav">
	<!--logo-->
	<!--<a class="top-logo" href="/">
		<img src="<?/*=$admin_logo*/?>"/>
	</a>-->
	<div id="top-tit" class="top-tit">
		<ul>
			<?php foreach ($menu as $item) : ?>
				<li>
					<a><?= $item['name'] ?></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
	<div class="top-right">
		<div class="search-parent">
			<form action="/menu/search" target="workSpace">
				<input type="text" id="input-search" name="input-search"/>
				<span id="search-btn">搜索</span>
			</form>
		</div>
		<div class="name-address">
			<?= $admin->realname ?>
		</div>
		<div class="member-header">
			<img src="<?= $avatar ?>"/>
		</div>
		<div class="close-img">
			<?= Html::beginForm(['/user/logout'], 'post', ['onsubmit' => 'return resub()']) ?>
			<input type="image" src="/static/admin/images/close-site.png" name="submit" align="">
			<?= Html::endForm() ?>
		</div>

	</div>
</div>

<!--左侧内容区域-->
<section id="aside-con" class="aside-con">
	<?php foreach ($menu as $item) : ?>
		<div class="mod <?= $item['icon'] ?>">
			<ul class="aside-con-left-ul">
				<?php foreach ($item['children'] as $val) : ?>
					<li class="cmenu <?= $val['icon'] ?>" data-uri="<?= $val['uri'] ?>">
						<a href="<?= $val['uri'] ?>" style="text-decoration: none">
							<i class="i-bg" style="background-image:url('/static/admin/images/<?= $val['icon'] ?: 'default' ?>.png') !important;"></i>
							<i class="i-bg-select" style="background-image:url('/static/admin/images/<?= $val['icon'] ?: 'default' ?>-select.png') !important;"></i>
							<span><?= $val['name'] ?></span>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	<?php endforeach ?>
</section>
<iframe name="workSpace" src="/index/index" class="container" id="myiframe" scrolling="no" onload="changeFrameHeight()"></iframe>
</body>
<script src="/static/admin/js/index_1.js" type="text/javascript" charset="utf-8"></script>
</html>
<script type="text/javascript">
	function resub() {
		return confirm('确认退出?');
	}

	function changeFrameHeight(){
		var ifm= document.getElementById("myiframe");
		ifm.height=document.documentElement.clientHeight;

	}

	window.onresize=function(){
		changeFrameHeight();

	}
</script>
