<?php

namespace backend\controllers;

use backend\models\Adviser;
use common\models\UploadForm;
use Yii;
use backend\models\ProjectAdviser;
use backend\models\ProjectAdviserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use conquer\helpers\Json;
use yii\web\UploadedFile;

/**
 * ProjectAdviserController implements the CRUD actions for ProjectAdviser model.
 */
class ProjectAdviserController extends Controller
{
    public $enableCsrfValidation = false;

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
     * Lists all ProjectAdviser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectAdviserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = Yii::$app->request->post('editableKey');
            $model = $this->findModel($id);

            // store a default json response as desired by editable
            $out = Json::encode(['output' => '', 'message' => '保存中...']);

            // fetch the first entry in posted data (there should only be one entry
            // anyway in this array for an editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $posted = current($_POST['ProjectAdviser']);
            $post = ['ProjectAdviser' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                // if (isset($posted['buy_amount'])) {
                // $output = Yii::$app->formatter->asDecimal($model->buy_amount, 2);
                // }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                // $output = ''; // process as you need
                // }
                $out = Json::encode(['output' => $output, 'message' => '保存成功']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectAdviser model.
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
     * Creates a new ProjectAdviser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new ProjectAdviser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/update', 'id' => $id]);
        }

        return $this->redirect(['project/update', 'id' => $id]);
    }

    /**
     * Updates an existing ProjectAdviser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post('ProjectAdviser');
        $model = $this->findModel($post['id']);

        if ($model->load(Yii::$app->request->post())) {
            if (isset($post['state']) && $post['state'] == 5) {
                $adviser = $model->adviser;
                $adviser->setAttribute('times', $adviser->times + 1);
                $adviser->save(false);
                $model->customer_fee = $model->hour * $model->project->unit_price;
            }
            if ($model->save()) {
                return $this->redirect(['project/update', 'id' => $id]);
            }
        }

        return $this->redirect(['project/update', 'id' => $id]);
    }

    /**
     * Deletes an existing ProjectAdviser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $project_id
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
    }

    /**
     * Finds the ProjectAdviser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectAdviser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectAdviser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionImport()
    {
        if (!$_FILES['file']) {
            Yii::$app->session->setFlash('error', '文件格式错误，请先另存为xls格式');
            return $this->redirect(['project-adviser/index']);
        } else {
            $filepath = Yii::$app->basePath.'/upload/';
            is_dir($filepath) OR mkdir($filepath, 0777, true);
            $destination = $filepath.$_FILES['file']['name'];

            if(move_uploaded_file($_FILES['file']['tmp_name'],$destination)){
                $PHPReader = new \PHPExcel_Reader_Excel2007(); // Reader很关键，用来读excel文件
                if (!$PHPReader->canRead($destination)) { // 这里是用Reader尝试去读文件，07不行用05，05不行就报错。注意，这里的return是Yii框架的方式。
                    $PHPReader = new \PHPExcel_Reader_Excel5();
                    if (!$PHPReader->canRead($destination)) {
                        Yii::$app->session->setFlash('error', '文件格式错误，请先另存为xls格式');
                        return $this->redirect(['project-adviser/index']);
                    }
                }
                $PHPExcel = $PHPReader->load($destination); // Reader读出来后，加载给Excel实例
                $currentSheet = $PHPExcel->getSheet(0); // 拿到第一个sheet（工作簿？）
                $allColumn = $currentSheet->getHighestColumn();
                if (strtoupper($allColumn) != 'AF') {
                    Yii::$app->session->setFlash('error', '文件列数错误，请先确定与导出的excel列数是否一致');
                    return $this->redirect(['project-adviser/index']);
                }
                foreach ($currentSheet->getRowIterator() as $key => $row) { // 行迭代器
                    if ($key > 1) {//去掉表头
                        $cellIterator = $row->getCellIterator(); // 拿到行中的cell迭代器
                        $cellIterator->setIterateOnlyExistingCells(false); // 设置cell迭代器，遍历所有cell，哪怕cell没有值
                        $lineVal = [];
                        foreach ($cellIterator as $cell) {
                            $lineVal[] = $cell->getValue();
                        }
                        $updateData = [
                            'bill_out' => $lineVal[15] == '是' ? 2 : 1,
                            'adviser_pay' => $lineVal[25] == '是' ? 2 : 1,
                            'referee_pay' => $lineVal[31] == '是' ? 2 : 1,
                        ];
                        ProjectAdviser::updateAll($updateData, ['id' => $lineVal[0]]);
                    }
                }
                Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['project-adviser/index']);
            }else{
                Yii::$app->session->setFlash('error', '上传失败');
                return $this->redirect(['project-adviser/index']);
            }
        }
    }

    public function actionAdviser($keyword)
    {
        echo json_encode((new Adviser())->getAdviserByKeyWord($keyword),JSON_UNESCAPED_UNICODE);
        exit();
    }
}
