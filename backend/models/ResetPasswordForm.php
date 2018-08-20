<?php
namespace backend\models;

use yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use backend\models\Admin;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $id;
    public $oldpassword;
    public $newpassword;

    /**
     * @var \common\models\User
     */
    private $admin;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'oldpassword', 'newpassword'], 'required'],
            ['id', 'validateId'],

            [['oldpassword', 'newpassword'], 'required'],
            [['oldpassword', 'newpassword'], 'string', 'min' => 6],

            ['oldpassword', 'validatePassword'],
        ];
    }

    /**
     * 字段的显示
     *
     * @return void
     */
    public function attributeLabels()
    {
        return [
            'oldpassword' => Yii::t('app', 'Old Password'),
            'newpassword' => Yii::t('app', 'New Password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->admin || !$this->admin->validatePassword($this->oldpassword)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

     /**
     * 验证 username 的存在
     *
     * @return void
     */
    public function validateUsername()
    {
        $this->admin = Admin::findByUsername($this->username);
        if (!$this->admin) {
            $this->addError($attribute, 'Incorrect username.');
        }
    }

    /**
     * 验证 uesrID 的存在
     *
     * @return void
     */
    public function validateId()
    {
        $this->admin = Admin::findById($this->id);
        if (!$this->admin) {
            $this->addError($attribute, 'Incorrect username.');
        }
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $this->admin->setPassword($this->newpassword);

        return $this->admin->save(false);
    }
}
