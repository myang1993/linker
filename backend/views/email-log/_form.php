<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'to_emails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_emails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bcc_emails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'context')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
