<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use admin\models\search\AdminLogSearch;
use common\helpers\FileHelper;
use common\helpers\Helper;
use common\models\table\AdminLog;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * AdminLogController implements the CRUD actions for AdminLog model.
 */
class AdminLogController extends AuthController
{
    public $enableCsrfValidation = false;
    /**
     * Lists all AdminLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = AdminLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpload()
    {
        $request = Yii::$app->getRequest();

        if ($request->getIsPost()) {

            $test = UploadedFile::getInstancesByname('files');
            var_dump($test);
            var_dump($_FILES);exit;
            if (isset($_FILES['file']['name'])) {
                $fname = $request->post('fname');
                $cid = $request->post('cid');

                $path_parts = pathinfo($fname);
                $path = $path_parts['dirname'];
                $path = 'template_script/' . $cid . '/' . $path;

                $upload = FileHelper::fileUpload($_FILES['file'], $path);

                if ($upload['errno'] == 0) {
                    $key = $upload['key'];
                } else {
                    return [
                        'code' => 102,
                        'msg' => $upload['msg']
                    ];
                }
            }

            if (!isset($key) || empty($key)) {
                return [
                    'code' => 104,
                    'msg' => '请上传文件'
                ];
            }

            /*return [
                'code' => 0,
                'msg' => '',
                'data' => [
                    'url' => $key,
                    //'full_url' => Helper::getImageUrl($key)
                ]
            ];*/
        } else {
            return $this->render('test2');
        }
    }
}
