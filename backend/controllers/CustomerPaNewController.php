<?php

namespace backend\controllers;

use Yii;
use app\models\CustomerPaNew;
use app\models\CustomerPaNewSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerPaNewController implements the CRUD actions for CustomerPaNew model.
 */
class CustomerPaNewController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        set_time_limit(0);
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
     * Lists all CustomerPaNew models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerPaNewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerPaNew model.
     * @param string $id
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
     * Creates a new CustomerPaNew model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomerPaNew();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CustomerPaNew model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerPaNew model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerPaNew model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CustomerPaNew the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerPaNew::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStep1()
    {
        $url = 'http://www.chictr.org.cn/showproj.aspx?proj=18442';
        $header = [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: zh-CN,zh;q=0.9",
            "Cache-Control:no-cache",
            "Connection:keep-alive",
            "Host:www.chictr.org.cn",
            "Pragma:no-cache",
            "Referer: http://www.chictr.org.cn/searchproj.aspx",
            "Upgrade-Insecure-Requests: 1",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //加入gzip解析
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //加入重定向处理,加了重定向直接空白
        $output = curl_exec($ch);
        curl_close($ch);
        file_put_contents('aaaaaaaaaaaa.html',$output);
        list($header, $body) = explode("\r\n\r\n", $output);
        preg_match('/eval(.*)<\/script>/is',$body,$match);
        preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches_cookie);
        if (isset($match[1])) {
            echo json_encode([$match[1],explode(';', $matches_cookie[1][0])[0]]);
        } else {
            echo json_encode([0,explode(';', $matches_cookie[1][0])[0]]);
        }
    }

    public function actionStep2()
    {
        $post = Yii::$app->request->post();
        $dynamicurl = $post['dynamicurl'];
        $wzwsconfirm = $post['wzwsconfirm'];
        $wzwstemplate = $post['wzwstemplate'];
        $wzwschallenge = $post['wzwschallenge'];
        $header = [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: zh-CN,zh;q=0.9",
            "Cache-Control:no-cache",
            "Connection:keep-alive",
            "Cookie: {$wzwsconfirm}; wzwstemplate={$wzwstemplate}; wzwschallenge={$wzwschallenge}",
            "Host:www.chictr.org.cn",
            "Pragma:no-cache",
            "Referer: http://www.chictr.org.cn/searchproj.aspx",
            "Upgrade-Insecure-Requests: 1",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36",
        ];

        $url = "http://www.chictr.org.cn".$dynamicurl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //加入gzip解析
        $output = curl_exec($ch);
        curl_close($ch);
        file_put_contents('step2.html',$output);
        list($header, $body) = explode("\r\n\r\n", $output);
        preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches_cookie);
        Yii::info('matchs_cookie'.json_encode($matches_cookie));
        if (isset($matches_cookie[1][2])) {
            $this->actionStep3(explode(';',$matches_cookie[1][0])[0],explode(';',$matches_cookie[1][2])[0],$wzwsconfirm,$wzwstemplate);
        } else {
            echo json_encode(['status'=>1]);exit;
        }
    }

    public function actionStep3($ccpassport,$wzwsvtime,$wzwsconfirm,$wzwstemplate) {
        $rst= [];
        $header = [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: zh-CN,zh;q=0.9",
            "Cache-Control:no-cache",
            "Connection:keep-alive",
            "Cookie:{$ccpassport}; wzwsconfirm={$wzwsconfirm}; wzwstemplate={$wzwstemplate}; wzwschallenge=-1; {$wzwsvtime}; onlineusercount=1",
            "Host:www.chictr.org.cn",
            "Pragma:no-cache",
            "Referer: http://www.chictr.org.cn/searchproj.aspx",
            "Upgrade-Insecure-Requests: 1",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.162 Safari/537.36",
        ];

        $result = \Yii::$app->db->createCommand("select * from customer_pa_new order by page_id asc limit 1")->queryAll();
        for ($i = 1; $i <=30; $i++) {
            $page_id = $result[0]['page_id'] - $i;
            $url = "http://www.chictr.org.cn/showproj.aspx?proj={$page_id}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //加入gzip解析
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //加入重定向处理,加了重定向直接空白
            $output = curl_exec($ch);
            curl_close($ch);
            if (strlen($output) < 20000) {
                continue;
            }
            file_put_contents('pa/page_' . $page_id . '.html', $output);
            preg_match_all('/<div class="ProjetInfo_ms">(.*?)<\/div>/is', $output, $match);
            preg_match_all('/<tr(?:.*?)>(.*?)<\/tr>/is', $match[1][1], $match2);
            preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][0], $match3);
            preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][2], $match6);
            preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][4], $match9);
            preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][9], $match7);
            preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match3[1][1], $match4);
            preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match3[1][3], $match5);
            preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match7[1][1], $match8);
            preg_match_all('/<td(?:.*?)>(.*?)<\/td>/is', $match2[1][6], $match10);
            preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match10[1][1], $match11);
            preg_match_all('/<p(?:.*?)>(.*?)<\/p>/is', $match10[1][3], $match12);
            $application = trim(str_replace('&nbsp;', '', $match4[1][0]));
            $study_leadey = trim(str_replace('&nbsp;', '', $match5[1][0]));
            $telephone = trim(str_replace(['&nbsp;', '+86', ' '], '', $match6[1][1]));
            $leadey_telephone = trim(str_replace(['&nbsp;', '+86', ' '], '', $match6[1][3]));
            $position = trim(str_replace('&nbsp;', '', $match8[1][0]));
            $application_email = trim(str_replace('&nbsp;', '', $match9[1][1]));
            $leadey__email = trim(str_replace('&nbsp;', '', $match9[1][3]));
            $application_address = trim(str_replace('&nbsp;', '', $match11[1][0]));
            $study_leadey_address = trim(str_replace('&nbsp;', '', $match12[1][0]));
            $rst[] = [
                'application'=>$application,
                'study_leadey'=>$study_leadey,
                'telephone'=>$telephone,
                'leadey_telephone'=>$leadey_telephone,
                'position'=>$position,
                'application_email'=>$application_email,
                'leadey__email'=>$leadey__email,
                'application_address'=>$application_address,
                'study_leadey_address'=>$study_leadey_address,
            ];

            Yii::$app->db->createCommand()->insert('customer_pa_new', [
                'application' => $application,
                'study_leadey' => $study_leadey,
                'telephone' => $telephone,
                'leadey_telephone' => $leadey_telephone,
                'position' => $position,
                'application_email' => $application_email,
                'leadey__email' => $leadey__email,
                'application_address' => $application_address,
                'study_leadey_address' => $study_leadey_address,
                'page_id' => $page_id,
            ])->execute();

        }

        echo json_encode(['status'=>1,'data'=>$rst]);exit;
    }
}
