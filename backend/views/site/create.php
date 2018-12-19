<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Create';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup cu">
    <h3 class="title"><?= Html::encode($this->title) ?></h3>

    <p>Please fill out the following fields to create:</p>
    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'fieldConfig' => [
            'template' => "{label}{input}{error}",
            'labelOptions' => [],
        ],
        'options' => [
            'class' => 'form-inline form',
        ],
    ]); ?>
    <!--        --><?php //echo $form->errorSummary($model); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'department') ?>

        <?= $form->field($model, 'mobile_phone') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_compare')->passwordInput() ?>

        <div class="form-group form-group-block form-group-btn">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
