<?php

use common\helpers\JsBlock;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '版本号设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    th,td{text-align: center;}
    .flush , .upload , .hand{cursor: pointer;}
    span.opened{color: darkgreen;}
    span.closed{color: #ccc;}
</style>
<div class="menu-base-index" style="width: 600px;">
    <table class="table table-bordered table-striped">
        <tr>
            <th>端口</th>
            <th width='400'>版本</th>
            <th>刷新</th>
            <th>设置</th>
        </tr>
        <?php foreach ($versions as $v) :?>
        <tr>
            <td><?=$v->port_name?></td>
            <td port="<?=$v->port?>"><?=$v->version?></td>
            <td><?=Html::tag('span', '刷新', ['class' => 'flush', 'data-port' => $v->port])?></td>
            <td><?=Html::a('设置', ['version-set', 'port' => $v->port])?></td>
        </tr>
        <?php endforeach?>
    </table>
    <div style="padding: 15px;">刷新 即用 {yyyymmdd_HHiiss} 更新当前版本号</div>
</div>

<div class="menu-base-index" style="width: 800px;">
    <table class="table table-bordered table-striped">
        <tr>
            <th>端口</th>
            <th width='320'>URL</th>
            <th>开关</th>
            <th>设置</th>
            <th>上传文件</th>
            <th width="200">最后更新时间</th>
        </tr>
        <?php foreach ($cdns as $v) :?>
        <tr>
            <td><?=$v->port_name?></td>
            <td data-cdn-port ="<?=$v->port?>"><?= ($v->url) ? $v->url : $v->save ?></td>
            <td>
                <?php
                    $tag = ($v->url) ? '已开启' : '已关闭';
                    $cls = ($v->url) ? 'opened' : 'closed';
                    echo Html::tag('span', $tag, ['data-cdn-port' => $v->port, 'class' => "hand {$cls} swt"]);
                ?>
            </td>
            <td><?=Html::a('设置', ['cdn-set', 'port' => $v->port])?></td>
            <td><?=Html::button('上传', ['class' => 'upload btn btn-xs btn-warning', 'data-port' => $v->port])?></td>
            <td class="last-time" data-port="<?=$v->port?>"><?=getLastUploadTime($v->port)?></td>
        </tr>
        <?php endforeach?>
    </table>
</div>

<?php
    function getLastUploadTime($port) {
        $redis = Yii::$app->redis;
        $key = "last_upload_time:{$port}";
        $time_stamp = $redis->get($key);
        if ($time_stamp == null) {
            return '尚未更新';
        }
        return date('Y-m-d H:i:s', $time_stamp);
    }
?>

<div class="msg"> </div>
<?php JsBlock::begin() ?>
<script type="text/javascript">
var port='';
var flag=0;
var inter=setInterval(upload,3000);

function upload(){
    if(flag==1){
        $.ajax({
            url:'/menu/up-qiniu',
            type:'post',
            data:{'port':port},
            success:function(e){
                //console.log(e);
                $(".msg").html(e.data.port + ' ' +e.data.key + ' ' + e.msg);
                $(".msg").show();
                if(e.code>1){
                    setTimeout(function(){
                        $(".msg").hide();
                    },2800);
                }
                if(e.code==1){
                    flag=0;
                    $("td.last-time[data-port='"+e.data.port+"']").html(e.data.last_time);
                    $("button.upload").attr("disabled",false);
                    //alert(e.msg);
                    // clearInterval(inter);
                }
            }
        })
    }
}

$(function(){
    $(".flush").click(function(){
        if(!confirm('是否刷新此端版本号？')){
            return ;
        }
        var port=$(this).data('port');
        $.ajax({
            url:'/menu/version-flush',
            type:'post',
            data:{'port':port},
            success:function(e){
                if(e.code==0){
                    $("td[port='"+e.data.port+"']").html(e.data.version);
                }
                else{
                    alert('未知错误，请重试');
                }
            }
        })
    })

    $(".upload").click(function(){
        var _this=$(this);
        if(!confirm('是否上传改端口下的文件到七牛？')){
            return ;
        }

        var _port=$(this).data('port');
        $.ajax({
            url:'/menu/cdn-upload',
            type:'post',
            data:{'port':_port},
            success:function(e){
                port=e.port;
                if(e.count>0){
                    flag=1;
                    $("button.upload").attr("disabled","disabled");
                }
                else{
                    $("td.last-time[data-port='"+e.port+"']").html(e.data.last_time);
                    //alert('未找到新更新的文件');
                    $(".msg").html(e.port + '端 未找到新更新的文件');
                    $(".msg").show();
                }
            }
        })
    })

    $(document).on('click','span.swt',function(){
        var _this=$(this);
        var _port=$(this).data('cdn-port');
        $.ajax({
            url:'/menu/cdn-toggle',
            type:'post',
            data:{'port':_port},
            success:function(e){
                port=e.port;
                $(".msg").html(e.port + ' ' + e.type + ' ' + e.msg);
                $(".msg").show();
                if(e.code==0){
                    model=$("span.swt[data-cdn-port='"+e.port+"']");
                    model.html(e.tag);

                    model.toggleClass('opened');
                    model.toggleClass('closed');
                    // if(e.type=="close"){
                    //     $("td[data-cdn-port='"+e.port+"']").html('');
                    //     model.attr('title',e.saved);
                    // }
                    // else{
                    //     $("td[data-cdn-port='"+e.port+"']").html(e.saved);
                    //     model.attr('title',null);
                    // }
                }
            }
        })

    })
})
</script>
<?php JsBlock::end() ?>
