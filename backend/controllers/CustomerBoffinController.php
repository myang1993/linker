<?php

namespace backend\controllers;

use Yii;
use backend\models\CustomerBoffin;
use backend\models\CustomerBoffinSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerBoffinController implements the CRUD actions for CustomerBoffin model.
 */
class CustomerBoffinController extends Controller
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

    /**
     * 研究员列表
     *
     * @param integer $id
     * @return void
     */
    public function actionList($id)
    {
        $model = new CustomerBoffin();
        $list = $model->getCustomerBoffins($id);
        $result = [];
        foreach ($list as $key => $value) {
            $result[] = ['id' => $key, 'text' => $value];
        }

        echo json_encode($result);
    }

    /**
     * Info of Customer
     * @param integer $id
     * @return mixed
     */
    public function actionInfo($id)
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $info = $this->findModel($id)->getAttributes();
        // $model = new Customer();
        // $type = $model->unitType();
        // $tax_type = $model->taxType();

        Yii::$app->response->data = $info;
    }

    public function actionDetailView()
    {
        $boffin = new \backend\models\CustomerBoffin();
        echo \kartik\detail\DetailView::widget([
            'model' => $boffin,
            'condensed' => true,
            'hover' => true,
            'mode' => \kartik\detail\DetailView::MODE_VIEW,
            'panel' => [
                'heading' => 'Book # ' . $boffin->id,
                'type' => \kartik\detail\DetailView::TYPE_INFO,
            ],
            'attributes' => [
                'name_zh',
                'name_en',
                // ['attribute'=>'publish_date', 'type'=>DetailView::INPUT_DATE],
            ]
        ]);
    }

    /**
     * Lists all CustomerBoffin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerBoffinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerBoffin model.
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
     * Creates a new CustomerBoffin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new CustomerBoffin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['customer/update', 'id' => $model->customer_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CustomerBoffin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post('CustomerBoffin');
        $model = $this->findModel($post['id']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['customer/update', 'id' => $model->customer_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerBoffin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $post = Yii::$app->request->queryParams();
        $this->findModel($post['id'])->delete();

        if (Yii::$app->request->isAjax && isset($post['delete'])) {
            echo \yii\helpers\Json::encode([
                'success' => true,
                'messages' => [
                    'kv-detail-info' => 'The boffin ' . $post['id'] . ' was successfully deleted. ',
                ],
            ]);
            return;
        }

        return $this->redirect(['customer/update', 'id' => $id]);
    }

    /**
     * Finds the CustomerBoffin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerBoffin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerBoffin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
