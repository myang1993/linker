<?php

namespace backend\controllers;

use backend\models\ProjectAdviser;
use Yii;
use backend\models\Adviser;
use backend\models\AdviserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Area;
use yii\helpers\Html;

/**
 * AdviserController implements the CRUD actions for Adviser model.
 */
class AdviserController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSite($pid, $typeId = 0)
    {
        $model = new Area();
        $model = $model->getAreaList($pid);
        if ($typeId == 1) {
            $aa = "--请选择市--";
        } else if ($typeId == 2 && $model) {
            $aa = "--请选择区--";
        } else {
            $aa = "";
        }
        echo Html::tag('option', $aa, ['value' => '']);
        foreach ($model as $value => $name) {
            echo Html::tag('option', Html::encode($name), array('value' => $value));
        }
    }

    /**
     * Info of Adviser
     * @param integer $id
     * @return mixed
     */
    public function actionInfo($id)
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $info = $this->findModel($id)->getAttributes();
        $model = new Adviser();
        $type = $model->priceType();
        $tax_type = $model->taxType();

        $info['fee_face_type_v'] = $type[$info['fee_face_type']];
        $info['fee_phone_type_v'] = $type[$info['fee_phone_type']];
        $info['fee_road_type_v'] = $type[$info['fee_road_type']];
        $info['tax_type_v'] = $tax_type[$info['tax_type']];
        Yii::$app->response->data = $info;
    }

    /**
     * Lists all Adviser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdviserSearch();
//        print_r(Yii::$app->request->queryParams);exit;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adviser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adviser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adviser();
        $area = new Area();

        // if (Yii::$app->request->isAjax) {
        //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //     return \yii\bootstrap\ActiveForm::validate($model);
        // }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'area' => $area,
        ]);
    }

    /**
     * Updates an existing Adviser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $area = new Area();

        // if (Yii::$app->request->isAjax) {
        //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //     return \yii\bootstrap\ActiveForm::validate($model);
        // }

        if ($model->load(Yii::$app->request->post())) {
            $model->setAttribute('update_time', time());
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'area' => $area,
        ]);
    }

    /**
     * Deletes an existing Adviser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adviser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adviser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adviser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAddAdviserProject()
    {
        $queryParams = Yii::$app->request->queryParams;
        if (empty($queryParams['adviser_list']) || !is_array($queryParams['adviser_list']) || empty($queryParams['project_id'])) {
            echo json_encode(['status'=>-1,'message'=>'参数错误'],JSON_UNESCAPED_UNICODE);
        } else {
            $projectAdviserModel = new ProjectAdviser();
            foreach ($queryParams['adviser_list'] as $adviser_id) {
                $projectAdviserModel->addAdviserProject($adviser_id,$queryParams['project_id']);
            }
            echo json_encode(['status'=>0,'message'=>'success'],JSON_UNESCAPED_UNICODE);
        }
        Yii::$app->end();
    }
}
