<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-adviser-search search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'form-inline form',
        ],
    ]); ?>

    <?= $form->field($model, 'start_date')->widget(
        \kartik\datetime\DateTimePicker::className(),
        [
            'language' => 'zh-CN',
            'id' => 'pay_date',
            'convertFormat' => true,
            'options' => ['placeholder' => '请输入开始日期', 'style' => 'width:180px'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true,
            ]
        ]
    )->label(Yii::t('app', 'Start Time')); ?>

    <?= $form->field($model, 'end_date')->widget(
        \kartik\datetime\DateTimePicker::className(),
        [
            'language' => 'zh-CN',
            'id' => 'pay_date',
            'convertFormat' => true,
            'options' => ['placeholder' => '请输入结束日期', 'style' => 'width:180px'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true,
            ]
        ]
    )->label(Yii::t('app', 'End Time')); ?>
</br>
    <?= $form->field($model, 'project_name') ?>
    <?= $form->field($model, 'adviser_name') ?>
    <?= $form->field($model, 'bill_out')->dropDownList(['0' => '请选择', 1 => '否', 2 => '是']) ?>
    <?= $form->field($model, 'adviser_pay')->dropDownList(['0' => '请选择', 1 => '否', 2 => '是']) ?>
    <?= $form->field($model, 'referee_pay')->dropDownList(['0' => '请选择', 1 => '否', 2 => '是']) ?>

    <div class="form-group form-group-btn" style="vertical-align: top;">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
