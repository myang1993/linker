<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerCssFile('@web/css/index.css', ['depends' => ['backend\assets\AppAsset']]);

$this->title = Yii::t('app', 'Home');
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-4 col-md-offset-1 highlight box">
                <h3 class="text-center">个人信息</h3>
                <p>
                    <label>姓名:</label><?=$model->username ?>
                </p>
                <p>
                    <label>电话:</label><?=$model->mobile_phone ?>
                </p>
                <p>
                    <label>邮箱:</label><?=$model->email ?>
                </p>
                <p>
                    <label>部门:</label><?=$model->department ?>
                </p>
            </div>
        </div>

    </div>
</div>
