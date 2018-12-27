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
            <div class="col-md-4 col-md-offset-1 highlight box form-inline">
                <h3 class="text-center">个人信息</h3>

                <div class="form-group">
                    <label class="control-label text-center">访谈小时数:</label>
                    <p class="form-control-static"><strong><?= $hours ?></strong></p>
                </div></br>
                <div class="form-group">
                    <label class="control-label text-center">安排Call个数:</label>
                    <p class="form-control-static"><strong><?=$calls ?></strong></p>
                </div></br>
                <div class="form-group">
                    <label class="control-label text-center">完成Call个数:</label>
                    <p class="form-control-static"><strong><?= $complete_calls ?></strong></p>
                </div>
                </br>
                <div class="form-group">
                    <label class="control-label text-center">当前排名:</label>
                    <p class="form-control-static"><strong><?=$order ?></strong></p>
                </div></br>
                <div class="form-group">
                    <label class="control-label text-center">新专家率:</label>
                    <p class="form-control-static"><strong><?=$rate ?></strong></p>
                </div>
            </div>
        </div>

    </div>
</div>
