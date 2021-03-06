<?php
namespace backend\controllers;

use backend\models\Project;
use backend\models\ProjectAdviser;
use insolita\migrik\gii\StructureGenerator;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\Admin;
use backend\models\CreateForm;
use backend\models\ResetPasswordForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['login', 'logout', 'error', 'index', 'reset-password', 'language'], // only 选项指明存取控制过滤器（ACF）应当只对 login，logout 方法起作用， 没有列出的动作，将无条件获得授权
            //     'rules' => [
            //         [
            //             'actions' => ['login', 'error'],
            //             'allow' => true,
            //             'roles' => ['?'],
            //         ],
            //         [
            //             'actions' => ['logout', 'index', 'reset-password', 'language'],
            //             'allow' => true,
            //             'roles' => ['@'], // ? 是一个特殊的标识，代表”访客用户”，@是另一个特殊标识， 代表”已认证用户”。
            //         ],
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 语言切换
     *
     * @return string
     */
    public function actionLanguage()
    {
        $language = \Yii::$app->request->get('lang');
        if (isset($language)) {
            \Yii::$app->session['language'] = $language;
        }

        // 切换完语言哪来的返回到哪里
        $this->goBack(\Yii::$app->request->headers['Referer']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $model = Yii::$app->user->identity;
            $reset = new ResetPasswordForm();

            if ($reset->load(Yii::$app->request->post()) && $reset->validate() && $reset->resetPassword()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'New password saved.'));

                return $this->goHome();
            } elseif (Yii::$app->user->identity->updated_at <= Yii::$app->user->identity->created_at) {
                $this->redirect(['site/update-pass']);
            }

//            return $this->render('index', [
//                'model' => $model,
//                'reset' => $reset,
//            ]);
            $this->redirect(['site/home']);
        } else {
            $this->redirect(['site/login']);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->updated_at > Yii::$app->user->identity->created_at) {
                return $this->goBack();
            } else {
                $this->redirect(['site/update-pass']);
            }
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * create action
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new CreateForm();
        $model->setScenario('create');
        $model->load($_POST);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                // if (Yii::$app->getUser()->login($user)) {
                $this->redirect(['user/index']);
                // }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // /**
    //  * Resets password.
    //  * http://10.103.249.31/yii_project/backend/web/index.php?r=site%2Freset-password&username=yangxin
    //  *
    //  * @param string $token
    //  * @return mixed
    //  * @throws BadRequestHttpException
    //  */
    // public function actionResetPassword($username)
    // {
    //     $model = new ResetPasswordForm();

    //     if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    //         Yii::$app->session->setFlash('success', 'New password saved.');

    //         return $this->goHome();
    //     }

    //     return $this->render('resetPassword', [
    //         'model' => $model,
    //         'username' => $username,
    //     ]);
    // }

    public function actionFirstLogin() {
        if (Yii::$app->user->isGuest) {
            return 2;//还未登录
        }
        if(Yii::$app->user->identity->updated_at > Yii::$app->user->identity->created_at) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdatePass()
    {
        if (!Yii::$app->user->isGuest) {
            $model = Yii::$app->user->identity;
            $reset = new ResetPasswordForm();

            if ($reset->load(Yii::$app->request->post()) && $reset->validate() && $reset->resetPassword()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'New password saved.'));

                return $this->goHome();
            }

            return $this->render('update_pass', [
                'model' => $model,
                'reset' => $reset,
            ]);
        }

        $this->redirect(['site/login']);
    }

    /**
     * 个人信息
     * @return string
     */
    public function actionProfile()
    {
        if (!Yii::$app->user->isGuest) {
            $model = Yii::$app->user->identity;
            return $this->render('profile', [
                'model' => $model,
            ]);
        }

        $this->redirect(['site/login']);
    }

    public function actionHome()
    {
        if (!Yii::$app->user->isGuest) {
            $model = Yii::$app->user->identity;
            $db = Yii::$app->db;
            $user_id = Yii::$app->user->id;
            $date = strtotime(date('Y-m'));
            $hours = $db->createCommand("select sum(hour) hours from project_adviser where selector_id = {$user_id} and state = 6 and date >= {$date}")->queryAll();
            $calls = $db->createCommand("select count(*) calls from project_adviser where selector_id = {$user_id} and state in (4) and date >= {$date}")->queryAll();
            $complete_calls = $db->createCommand("select count(*) calls from project_adviser where selector_id = {$user_id} and state in (6) and date >= {$date}")->queryAll();
            $AllCalls = $db->createCommand("select count(*) calls,selector_id from project_adviser where state in (6) and date >= {$date} GROUP BY selector_id ORDER BY calls desc")->queryAll();
            $i = 0;
            if (!empty($AllCalls)) {
                foreach ($AllCalls as $key=> $value) {
                    if ($value['selector_id'] == $user_id) {
                        if (isset($AllCalls[$key-1]) && $AllCalls[$key-1]['calls'] > $value['calls']) {
                            $order = $key+1-$i;
                        } elseif (isset($AllCalls[$key-1]) && $AllCalls[$key-1]['calls'] == $value['calls']) {
                            $order = $key-$i;
                        } else {
                            $order = 1;
                        }
                    } else {
                        if (isset($AllCalls[$key-1]) && $AllCalls[$key-1]['calls'] == $value['calls']) {
                            $i++;
                        }
                    }
                }
            }
            $new_hours = $db->createCommand("select sum(hour) hours from project_adviser a join adviser b on a.adviser_id= b.id where selector_id = {$user_id} and a.state = 6 and a.date >= {$date} and b.create_time >= {$date}")->queryAll();
            if (empty($new_hours[0]['hours'])) {
                $new_hours = 0;
            } else {
                $new_hours = $new_hours[0]['hours'];
            }
            return $this->render('home', [
                'model' => $model,
                'hours' => isset($hours[0]['hours']) ?$hours[0]['hours']:0,
                'calls' => isset($calls[0]['calls']) ?$calls[0]['calls']:0,
                'complete_calls' => isset($complete_calls[0]['calls']) ? $complete_calls[0]['calls'] : 0,
                'order' => isset($order) ?$order:'',
                'rate'=> isset($hours[0]['hours']) ?$new_hours/$hours[0]['hours']:0

            ]);
        }

        $this->redirect(['site/login']);
    }

    public function actionBatchCustomerFee()
    {
        $lists = ProjectAdviser::find()->where(['state' => 6])->asArray()->all();
        foreach ($lists as $key => $value) {
            $customer_fee = Project::find()->joinWith('customer as a', true)->where(['project.id' => $value['project_id']])->asArray()->one();
            $fee = $value['hour'] * $value['fee_rate'] * $customer_fee['customer'][$value['pay_type']];
            ProjectAdviser::updateAll(['customer_fee' => $fee], ['id' => $value['id']]);
        }
    }
}
