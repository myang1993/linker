<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller
{
    /**
     * 创建权限
     * @param $item
     * @throws \Exception
     */
    public function actionCreatePermission($item)
    {
        $auth = Yii::$app->authManager;
        $createPost = $auth->createPermission($item);
        $createPost->description = '创建了 ' . $item . ' 许可';
        $auth->add($createPost);
    }

    /**
     * 创建角色
     * @param $item
     * @throws \Exception
     */
    public function actionCreateRole($item)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($item);
        $role->description = '创建了 ' . $item . ' 角色';
        $auth->add($role);
    }


    /**
     * 给角色分配许可
     * @param $items
     * @throws \yii\base\Exception
     */
    static public function createEmpowerment($items)
    {
        $auth = Yii::$app->authManager;
        $parent = $auth->createRole($items['name']);
        $child = $auth->createPermission($items['description']);
        $auth->addChild($parent, $child);
    }

    /**
     * 给角色分配用户
     * @param $item
     * @throws \Exception
     */
    static public function assign($item)
    {
        $auth = Yii::$app->authManager;
        $reader = $auth->createRole($item['name']);
        $auth->assign($reader, $item['description']);
    }
}