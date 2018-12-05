<?php

namespace backend\controllers;

use backend\models\AdviserSearch;
use backend\models\ProjectAdviserSearch;
use backend\models\ProjectBoffinSearch;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use backend\models\Customer;
use backend\models\Adviser;
use backend\models\Project;
use backend\models\ProjectSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
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
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $searchModel = new ProjectAdviserSearch();
        $dataProvider = $searchModel->updateSearch($id);
        $projectBoffinSearch = new ProjectBoffinSearch();
        $projectBoffinProvider = $projectBoffinSearch->search(['ProjectBoffinSearch' => ['project_id' => $id]]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/update', 'id' => $model->id]);
        }
//        echo Yii::$app->controller->action->id;exit;
        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'projectBoffinProvider' => $projectBoffinProvider,
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('status', 10);
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionGetProject()
    {
        $queryParams =Yii::$app->request->queryParams;
        if (empty($queryParams['keyword'])) {
            echo json_encode(['status'=>-1,'message'=>'请输入搜索信息'],JSON_UNESCAPED_UNICODE);
        } else {
            $keyword = urldecode($queryParams['keyword']);
            $data = (new Project())->getProjectList($keyword);
            echo json_encode(['status'=>0,'message'=>'success','data'=>$data],JSON_UNESCAPED_UNICODE);
        }
        exit();
    }
}
