<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use admin\models\AdminMenu;
use admin\models\form\CdnForm;
use admin\models\form\VersionForm;
use common\helpers\Message;
use common\services\Etag;
use common\services\QiniuService;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class MenuController extends AuthController
{
    public function actionIndex()
    {
        $searchModel = new AdminMenu();
        $params = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($pid = 0)
    {
        $model = new AdminMenu();
        $model->pid = $pid;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Message::setSuccessMsg('添加成功');
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                Message::setErrorMsg('添加失败');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Message::setSuccessMsg('修改成功');
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                Message::setErrorMsg('修改失败');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSearch()
    {
        $keyword = Yii::$app->request->get('input-search', '');
        $query = AdminMenu::find();
        if (!empty($keyword)) {
            $query->andFilterWhere([
                    'OR',
                    ['like', 'name', $keyword],
                    ['like', 'description', $keyword],
                ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVersionList()
    {
        $ports = VersionForm::portMap();
        $model = new VersionForm();
        $versions = [];
        foreach ($ports as $port => $port_name) {
            $_model = clone $model;
            $_model->port = $port;
            $_model->port_name = $port_name;
            $_model->getAttr();
            $versions[] = $_model;
        }

        $model = new CdnForm();
        $cdns = [];
        foreach ($ports as $port => $port_name) {
            $_model = clone $model;
            $_model->port = $port;
            $_model->port_name = $port_name;
            $_model->getAttr();
            $cdns[] = $_model;
        }

        return $this->render('version-list', [
            'versions' => $versions,
            'cdns' => $cdns,
        ]);
    }

    public function actionVersionSet($port)
    {
        $model = new VersionForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Message::setSuccessMsg('修改成功');
                return $this->redirect(['version-list']);
            } else {
                Message::setErrorMsg($model->getErrors());
            }
        } else {
            $model->port = $port;
            $model->getAttr();
        }

        return $this->render('version-set', [
            'model' => $model,
        ]);
    }

    public function actionVersionFlush()
    {
        Yii::$app->response->format = 'json';
        $port = Yii::$app->request->post('port', '');
        if ($port == '') {
            return ['code' => 101, 'msg' => 'bad request'];
        }
        $key = 'static_version_'.$port;
        $version = date('Ymd_His');
        $redis = Yii::$app->redis;
        if ($redis->set($key, $version)) {
            return [
                'code' => 0,
                'msg' => 'success',
                'data' => [
                    'port' => $port,
                    'version' => $version,
                    ],
                ];
        }
        return ['code' => 500, 'msg' => 'nuknow error'];
    }

    protected function findModel($id)
    {
        if (($model = AdminMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCdnSet($port)
    {
        $model = new CdnForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Message::setSuccessMsg('修改成功');
                return $this->redirect(['version-list']);
            } else {
                Message::setErrorMsg($model->getErrors());
            }
        } else {
            $model->port = $port;
            $model->getAttr();
        }

        return $this->render('cdn-set', [
            'model' => $model,
        ]);
    }

    public function actionCdnToggle()
    {
        Yii::$app->response->format = 'json';

        $model = new CdnForm();
        $port = Yii::$app->request->post('port', '');
        $model->port = $port;
        return $model->toggle();
    }

    // 上传static内文件到七牛
    public function actionCdnUpload()
    {
        Yii::$app->response->format = 'json';
        $port = Yii::$app->request->post('port', '');
        $ports = ['admin', 'pc', 'm', 'mch'];
        if (!in_array($port, $ports)) {
            return ['port' => $port, 'count' => 0];
        }

        $dir = Yii::getAlias("@$port");
        $dir = "$dir/web/static/";

        $num = $this->setCount($port);
        if ($num) {
            return ['port' => $port, 'count' => $num];
        }

        $this->read_all($dir, $dir, $port);
        $num = $this->setCount($port);
        if ($num > 0) {
            $this->updateLastTime($port);
        }
        $last_time = $this->lastTime($port);
        return [
            'port' => $port,
            'count' => $num,
            'data' => [
                'last_time' => date('Y-m-d H:i:s', $last_time),
                ],
            ];
    }

    // 摘取文件，并处理
    public function read_all($file, $_dir, $port)
    {
        if (!file_exists($file)) {
            return false;
        }
        if (is_file($file)) {
            $this->setList($file, $_dir, $port);
        } else {
            $handle = opendir($file);
            if ($handle) {
                while ($fl = readdir($handle)) {
                    $temp = $file.'/'.$fl; //DIRECTORY_SEPARATOR
                    if (is_dir($temp)) {
                        if ($fl != '.' && $fl != '..') {
                            $this->read_all($temp, $_dir, $port);
                        }
                    } else {
                        $this->setList($temp, $_dir, $port);
                    }
                }
            }
        }
    }

    public function setList($file, $_dir, $port)
    {
        $key = 'static'.str_replace($_dir, '', $file);
        $file_modify_time = filemtime($file);
        $val = "{$file}###{$key}";

        $redis = Yii::$app->redis;
        $key = "cdn_files:{$port}";

        $last_upload_time = $this->lastTime($port);
        if ($file_modify_time > $last_upload_time) {
            $redis->sadd($key, $val);
        }
    }

    public function setCount($port)
    {
        $redis = Yii::$app->redis;
        $key = "cdn_files:{$port}";
        return count($redis->smembers($key));
    }

    public function lastTime($port)
    {
        $redis = Yii::$app->redis;
        $key = "last_upload_time:{$port}";
        $time_stamp = $redis->get($key);
        if ($time_stamp == null) {
            $time_stamp = 0;
        }
        return $time_stamp;
    }

    public function updateLastTime($port)
    {
        $redis = Yii::$app->redis;
        $key = "last_upload_time:{$port}";
        $time_stamp = time();
        $redis->set($key, $time_stamp);
    }

    public function actionUpQiniu()
    {
        Yii::$app->response->format = 'json';

        $port = Yii::$app->request->post('port', '');
        if ($port == '') {
            return ['code' => 1, 'msg' => 'bad request'];
        }

        $last_time = time();

        $redis = Yii::$app->redis;
        $key = "cdn_files:{$port}";
        $val = $redis->spop($key);
        if ($val == null) {
            $last_time = $this->lastTime($port);
            return [
                'code' => 1,
                'msg' => '队列传送完成',
                'data' => [
                    'port' => $port,
                    'key' => '',
                    'last_time' => date('Y-m-d H:i:s', $last_time),
                    ],
                ];
        }

        list($file, $key) = explode('###', $val);

        if (!file_exists($file)) {
            return [
                'code' => 101,
                'msg' => '文件不存在',
                'data' => [
                    'port' => $port,
                    'key' => $key,
                    'last_time' => date('Y-m-d H:i:s', $last_time),
                    ],
                ];
        }

        $f_size = filesize($file);
        if ($f_size == 0) {
            return [
                'code' => 102,
                'msg' => '文件0字节',
                'data' => [
                    'port' => $port,
                    'key' => $key,
                    ],
                ];
        }

        // 文件对比

        $file_info = QiniuService::fileInfo($key);
        $hash = Etag::GetEtag($file);
        if (isset($file_info['hash']) && $file_info['hash'] == $hash) {
            return [
                'code' => 122,
                'msg' => '文件相同，不做处理',
                'data' => [
                    'port' => $port,
                    'key' => $key,
                    ],
                ];
        }

        QiniuService::delete($key);

        $code = 110;
        $result = 'faild';

        $up = QiniuService::upload($file, $key);
        if ($up) {
            $result = 'success';
            $code = 0;
        } else {
            // 恢复此项到队列
            $redis->sadd($key, $val);
        }
        return [
            'code' => $code,
            'msg' => $result,
            'data' => [
                    'port' => $port,
                    'key' => $key,
                    ],
            ];
    }
}
