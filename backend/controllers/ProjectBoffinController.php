<?php

namespace backend\controllers;

use Yii;
use backend\models\ProjectBoffin;
use backend\models\ProjectBoffinSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectBoffinController implements the CRUD actions for ProjectBoffin model.
 */
class ProjectBoffinController extends Controller
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
     * Lists all ProjectBoffin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectBoffinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectBoffin model.
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
     * Creates a new ProjectBoffin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new ProjectBoffin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/update', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProjectBoffin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post('ProjectBoffin');
        $model = $this->findModel($post['id']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/update', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectBoffin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $project_id)
    {
        $post = Yii::$app->request->queryParams;

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

        return $this->redirect(['project/update', 'id' => $project_id]);

        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectBoffin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectBoffin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectBoffin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
