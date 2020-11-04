<?php

use yii\helpers\Html;
use common\helpers\JsBlock;
use common\helpers\Render;
use common\services\AdminService;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '账号列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    'id',
    [
        'attribute' => 'admin_id',
        'value' => function ($model) {
            return AdminService::getNameById($model->admin_id);
        }
    ],
    'title',
    'account',
    [
        'header' => '密码',
        'attribute' => 'password',
        'format' => 'raw',
        'value' => function ($model) {
            return "<span id='password-$model->id'>".Html::button('查看', ['class' => 'see btn btn-xs btn-info', 'account-id' => $model->id]).'</span>';
        }
    ],
    //'password',
    //'url',
    'order_index',
    'create_at',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete}',
    ],
];
?>
<div class="account-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加账号', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]); ?>
</div>

<?php JsBlock::begin() ?>
<script type="text/javascript">
    $(function () {
        $(document).on("click", ".see", function (event) {
            var target = $(event.target);
            var id = target.attr("account-id");
            $.ajax({
                url: '/account/see',
                type: 'post',
                data: {id: id},
                success: function (e) {
                    if (e.code == 0) {
                        target.hide();
                        var str = '#password-' + id
                        $(str).text(e.password);

                    } else {
                        VCT.Toast(e.msg, 1500);
                    }
                }
            })

        });
    })
</script>
<?php JsBlock::end() ?>
