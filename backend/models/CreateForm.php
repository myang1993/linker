<?php
namespace backend\models;

use yii\base\Model;
use backend\models\Admin;

/**
 * Signup form
 */
class CreateForm extends Model
{
    public $username;
    public $email;
    public $department;
    public $mobile_phone;
    public $password;
    public $password_compare;
    public $created_at;
    public $updated_at;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'department', 'mobile_phone', 'password', 'password_compare'], 'trim'],
            [['username', 'email', 'department', 'mobile_phone', 'password', 'password_compare'], 'required'],

            [['username', 'email', 'mobile_phone'], 'unique', 'targetClass' => 'backend\models\Admin', 'message' => '{attribute}已经被占用了'],

            ['username', 'string', 'min' => 2, 'max' => 255],

            ['department', 'string', 'min' => 2, 'max' => 255],

            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'backend\models\Admin', 'message' => 'This email address has already been taken.'],

            ['mobile_phone', 'match', 'pattern' => '/^1[0-9]{10}$/', 'message' => '{attribute}必须为1开头的11位纯数字'],

            [['password', 'password_compare'], 'string', 'min' => 6, 'max' => 16],
            ['password_compare', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不一致'],

            ['created_at', 'default', 'value' => time()],

            ['updated_at', 'default', 'value' => time()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function signup()
    {
        if ($this->validate()) {
            $admin = new Admin();
            $admin->username = $this->username;
            $admin->email = $this->email;
            $admin->department = $this->department;
            $admin->mobile_phone = $this->mobile_phone;
            $admin->setPassword($this->password);
            $admin->created_at = $this->created_at;
            $admin->updated_at = $this->updated_at;
            $admin->generateAuthKey();
            $admin->save(false);

            /**
             * 添加鉴权
             * 访问鉴权
             * if (\Yii::$app->user->can('createPost')) {
             * // create post
             * }
             */
            // $auth = \Yii::$app->authManager;
            // $authorRole = $auth->getRole('author');
            // $auth->assign($authorRole, $admin->getId());

            return $admin;
        }

        return null;
    }

    public function update()
    {
        if ($this->validate()) {
            $admin = new Admin();
            $admin->username = $this->username;
            $admin->email = $this->email;
            $admin->department = $this->department;
            $admin->mobile_phone = $this->mobile_phone;
            $admin->setPassword($this->password);
            $admin->updated_at = $this->updated_at;
            $admin->generateAuthKey();
            $admin->save(false);

            /**
             * 添加鉴权
             * 访问鉴权
             * if (\Yii::$app->user->can('createPost')) {
             * // create post
             * }
             */
            // $auth = \Yii::$app->authManager;
            // $authorRole = $auth->getRole('author');
            // $auth->assign($authorRole, $admin->getId());

            return $admin;
        }

        return null;
    }
}
