<?php

namespace console\controllers;

use Yii;
use backend\models\Admin;

class InitController extends \yii\console\Controller
{
    /**
     * 初始化后台用户
     */
    public function actionAdmin()
    {
        echo "创建一个新用户 ...\n";                  // 提示当前操作
        $username = $this->prompt('User Name:');        // 接收用户名
        $email = $this->prompt('Email:');               // 接收Email
        $password = $this->prompt('Password:');         // 接收密码
        $model = new Admin();                            // 创建一个新用户
        $model->username = $username;                   // 完成赋值
        $model->email = $email;
        $model->password_hash = $password;
        if (!$model->save())                            // 保存新的用户
        {
            foreach ($model->getErrors() as $error)     // 如果保存失败，说明有错误，那就输出错误信息。
            {
                foreach ($error as $e) {
                    echo "$e\n";
                }
            }
            return 1;                                   // 命令行返回1表示有异常
        }
        return 0;                                       // 返回0表示一切OK
    }

    /**
     * 初始化角色
     *
     * @return void
     */
    public function actionInitRule()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // 添加 "createPost" 权限
        $createPost = $auth->createPermission('createPost');
        $createPost->description = '创建帖子';
        $auth->add($createPost);

        // 添加 "updatePost" 权限
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = '修改帖子';
        $auth->add($updatePost);

        // 添加 "author" 角色并赋予 "createPost" 权限
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // 添加 "admin" 角色并赋予 "updatePost"
		// 和 "author" 权限
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id
        // 通常在你的 User 模型中实现这个函数。
        // $auth->assign($author, 2);
        $authorRole = $auth->getRole('author');
        $auth->assign($authorRole, 1);
    }
}