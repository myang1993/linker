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
            <div class="col-md-4 col-md-offset-2 box">
                <h3 class="text-center">修改密码</h3>
                <?php $form = ActiveForm::begin(['action' => ['site/index'], 'method' => 'post', 'id' => 'index-form']); ?>

                    <?= $form->field($reset, 'id')->hiddenInput(['autofocus' => true, 'value' => $model->id])->label(false) ?>
                    <?= $form->field($reset, 'oldpassword')->passwordInput(['autofocus' => true]) ?>
                    <?= $form->field($reset, 'newpassword')->passwordInput(['autofocus' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
