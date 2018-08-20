<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectAdviser */
/* @var $form yii\widgets\ActiveForm */
$adviser = new \backend\models\Adviser();
?>

<div class="project-adviser-form cu">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-inline form',
        ],

        'fieldConfig' => [  // 为每一个input 设置
            'template' => "{label}{input}{error}",
            'labelOptions' => ['class' => ''],    // 设置label 的属性 添加class
        ],
    ]); ?>


    <?= $form->field($model, '[1]project_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, '[1]adviser_id')->hiddenInput()->dropDownList(
        $adviser->getAdviser(),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
        ]
    ) ?>

    <?= $form->field($model, '[1]state')->hiddenInput()->dropDownList(
        $model->stateType(),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
        ]
    ) ?>

    <?= $form->field($model, '[1]remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, '[1]pay_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, '[1]date')->widget(
        DatePicker::className(),
        [
            'inline' => false,
            'options' => ['value' => ($model->date > 0) ? date("Y-m-d", $model->date) : date('Y-m-d')],
            'language' => 'zh-CN',
            'clientOptions' => [
                'autoclose' => false,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <div class="form-group form-group-block form-group-btn">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
