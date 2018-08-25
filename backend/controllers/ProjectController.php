<?php

namespace backend\controllers;

use backend\models\AdviserSearch;
use backend\models\ProjectAdviserSearch;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use backend\models\Customer;
use backend\models\Adviser;
use backend\models\Project;
use backend\models\ProjectSearch;
use yii\filters\AccessControl;
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
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/update', 'id' => $model->id]);
        }
//        echo Yii::$app->controller->action->id;exit;
        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
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

    public function actionPaqu()
    {

        $url = "https://18621066281.lieguanjia.net/api/account/login";
        $header = [
            "Accept: application/json, text/plain, */*",
            "Cookie: UM_distinctid=1656c21406dd18-0a90b0c9926389-3a614108-100200-1656c21406ebfe; JSESSIONID=743C2F3FEF0B1BC5F5EC32AC20511E92; remember=1; last_login=18621066281; user_session=%7B%7D; CNZZDATA1261213312=1934552285-1535115910-%7C1535121442",
            "Referer: https://18621066281.lieguanjia.net/",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36",
            "Accept-Encoding: gzip, deflate, br",
            "Accept-Language: zh-CN,zh;q=0.9",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Content-Length: 47",
            "Content-Type: application/json;charset=UTF-8",
            "Host: 18621066281.lieguanjia.net",
        ];
        $post_data = [
            "account"=>"18621066281",
            "password"=>"ivanka961",
        ];
        $ch = curl_init($url);
        //设置头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_ENCODING, ' gzip, deflate');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $cons = curl_exec($ch);

        var_dump($cons);
    }
}
