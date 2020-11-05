<?php
Yii::$container->set('yii\data\Pagination', [
	'pageParam' => 'page',
	'pageSizeParam' => 'pageSize',
	'defaultPageSize' => 20,
	'validatePage' => false,
	'pageSizeLimit' => [1, 100],
]);
