<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\FinanceForm;

/**
 * Finance controller.
 */
class FinanceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Finance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new FinanceForm();
        if (Yii::$app->request->post()) {
            $savepath = 'runtime/attachment/' . date('Ymd') . 'xls/';
            $data = $model->upload_file('import_file', $savepath, time() . mt_rand(01, 10), ['xls', 'xlsx']);
            if (isset($data['absolute_path'])) {
                $info = $model->orgusermanager_import($data['absolute_path']);die;
                //输出导入错误信息
                if (!empty($info)) {
                    return json_encode($info, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode('导入成功', JSON_UNESCAPED_UNICODE);
                }
            }
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        return '请上传xls文件';
    }
}
