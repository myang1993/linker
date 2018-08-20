<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-search search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'form-inline form',
        ],
    ]); ?>

    <?= $form->field($model, 'start[0]')->widget(
        DatePicker::className(),
        [
            'inline' => false,
            'language' => 'zh-CN',
            'options' => ['value' => date('Y-m-d', strtotime('-1 month'))],
            'clientOptions' => [
                'autoclose' => false,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    )->label(Yii::t('app', 'Start Time')); ?>

    <?= $form->field($model, 'start[1]')->widget(
        DatePicker::className(),
        [
            'inline' => false,
            'language' => 'zh-CN',
            'options' => ['value' => date('Y-m-d')],
            'clientOptions' => [
                'autoclose' => false,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    )->label(Yii::t('app', 'End Time')); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'head') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'second') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'fee_time') ?>

    <div class="form-group form-group-btn" style="vertical-align: top;">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
