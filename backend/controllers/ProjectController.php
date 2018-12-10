<?php

namespace backend\controllers;

use app\models\EmailLog;
use backend\models\AdviserSearch;
use backend\models\CustomerBoffin;
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

    public function actionSend($customer_id,$project_id)
    {

        $model = new EmailLog();

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $mail= Yii::$app->mailer->compose();
            $mail->setTo(explode(';',$params['EmailLog']['to_emails']));
            if (!empty($params['EmailLog']['cc_emails'])) {
                $mail->setCc(explode(';',$params['EmailLog']['cc_emails']));
                $model->cc_emails = $params['EmailLog']['cc_emails'];
            }
            $mail->setBcc(['3029034139@qq.com']);

            $mail->setSubject("安排专家访谈");
            $mail->setHtmlBody($params['EmailLog']['content']);    //发布可以带html标签的文本
            if($mail->send()){
                $model->status = 1;
                Yii::$app->getSession()->setFlash('success', '发送成功');
            } else {
                $model->status = 2;
                Yii::$app->getSession()->setFlash('error', '发送失败');
            }
            $model->create_time = date('Y-m-d');
            $model->create_uid = Yii::$app->user->id;
            $model->to_emails = $params['EmailLog']['to_emails'];
            $model->content = $params['EmailLog']['content'];
            $model->save();
            return $this->redirect(['update', 'id' => $project_id]);
        } else {
            $content = '';
            $customer_email = CustomerBoffin::find()->select('email')->where(['customer_id'=>$customer_id])->asArray()->all();
            $customer_email = implode(';',array_filter(array_column($customer_email,'email')));
            $cc_email = 'bruce.huang@linkerintel.com;scott.yang@linkerintel.com';

            //邮件内容
            if (!empty(Project::findOne($project_id)->projectBoffins[0])) {
                $content =  Project::findOne($project_id)->projectBoffins[0]->boffin->name_zh . '你好：<br>&nbsp;&nbsp;&nbsp;&nbsp;我是Linker的' . Yii::$app->user->identity->username
                    . '，下面几位专家您看是否合适，如果有需要约访的，欢迎您随时联系我，谢谢。<br>';

                foreach (Project::findOne($project_id)->projectAdvisers as $index => $projectAdviser) {
                    $content .= '<div class="row" style="padding: 15px 15px 5px;"><div class="col-md-12" style="">ID:' . ($index + 1) . '</div><div class="col-md-12" style="line-height:20px; font-weight: bold;">' . $projectAdviser->adviser->company . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $projectAdviser->adviser->position . '</div><div class="col-md-12"><span style="font-weight:bold;">Experience:&nbsp;&nbsp;</span>' . $projectAdviser->adviser->describe . '</div><div class="col-md-12"><span style="font-weight:bold;">Comments:&nbsp;&nbsp;</span>' . $projectAdviser->remark . '</div><div class="col-md-12" style="height:10px;">&nbsp;&nbsp;</div></div>';
                }
            }
            $model->content = $content;
            $model->to_emails = $customer_email;
            $model->cc_emails = $cc_email;
            return $this->render('send_email', [
                'model' => $model,
            ]);
        }
    }

}
