<?php

namespace backend\controllers;

use Yii;
use backend\models\ProjectItem;
use backend\models\ProjectItemSearch;
use backend\models\ProjectAdviserCustomer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * ProjectItemController implements the CRUD actions for ProjectItem model.
 */
class ProjectItemController extends Controller
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
     * Lists all ProjectItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new ProjectItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectItem();
        $projectAdviserCustomer = new ProjectAdviserCustomer();

        if ($model->load(Yii::$app->request->post())) {
            if ($projectAdviserCustomer->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                if ($model->save()) {
                    $projectAdviserCustomer->setAttribute('project_id', $model->id);
                    if ($model->id && $projectAdviserCustomer->save()) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } else {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'proadcu' => $projectAdviserCustomer,
        ]);
    }

    /**
     * Updates an existing ProjectItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $projectAdviserCustomer = ProjectAdviserCustomer::find()->andFilterWhere([
            'project_id' => $model->id,
        ])->all();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $post = Yii::$app->request->post();

            foreach ($post['ProjectAdviserCustomer'] as $projectAdviserCustomerAttr) {
                $proAdsCusModel = ProjectAdviserCustomer::findOne($projectAdviserCustomerAttr['id']);
                $proAdsCusModel->setAttributes($projectAdviserCustomerAttr);

                if (!$proAdsCusModel->save()) {
                    $transaction->rollBack();
                }
            }

            if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'proadcu' => $projectAdviserCustomer,
        ]);
    }

    /**
     * Deletes an existing ProjectItem model.
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
     * Finds the ProjectItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
