<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $department
 * @property string $mobile_phone
 * @property int $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProjectStaff[] $projectStaff
 * @property ProjectAdviser[] $projectAdviser
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    const AUTH_KEY = '123456';
    public $password;
    public $password_compare;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', ], 'required'],
            [['username', 'email', 'department'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['username'], 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['auth_key', 'default', 'value' => self::AUTH_KEY],
            ['created_at', 'default', 'value' => time()],
            ['updated_at', 'default', 'value' => time()],
            ['role', 'in', 'range' => [self::ROLE_USER]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'email' => Yii::t('app', 'Email'),
            'department' => Yii::t('app', 'Department'),
            'mobile_phone' => Yii::t('app', 'Mobile Phone'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by id
     *
     * @param int $id
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStaff()
    {
        return $this->hasMany(ProjectStaff::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAdviser()
    {
        return $this->hasMany(ProjectAdviser::className(), ['selector_id' => 'id']);
    }

    /**
     * 员工列表
     * @return void
     */
    public function getAdminList()
    {
        $model = $this->find()->all();
        return yii\helpers\ArrayHelper::map($model, 'username', 'username');
    }

    /**
     * 员工列表
     * @return void
     */
    public function getAdminIdList()
    {
        $model = $this->find()->all();
        return yii\helpers\ArrayHelper::map($model, 'id', 'username');
    }

    /**
     * {@inheritdoc}
     * @return \app\models\AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\AdminQuery(get_called_class());
    }
}
