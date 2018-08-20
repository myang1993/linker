<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=> [
            'class'  => 'form-inline',
            'data-pjax' => 1
        ]
    ]); ?>

    <?= $form->field($model, 'id')->input('text',['style' => 'width: 100px']) ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'describe') ?>

    <?= $form->field($model, 'website') ?>

    <?= $form->field($model, 'pay_style') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group" style="vertical-align: top;">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
