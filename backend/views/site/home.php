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
                    <label>访谈小时数:</label><?=$hours ?>小时
                </p>
                <p>
                    <label>安排Call个数:</label><?=$calls ?>
                </p>
                <p>
                    <label>当前排名:</label><?=$order ?>
                </p>
                <p>
                    <label>新专家率:</label><?=$rate ?>
                </p>
            </div>
        </div>

    </div>
</div>