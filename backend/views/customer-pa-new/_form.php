<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPaNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-pa-new-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'application')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'application_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'study_leadey_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'study_leadey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leadey_telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'application_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leadey__email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'page_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
