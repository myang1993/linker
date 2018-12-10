<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-log-form" style="margin-top: 50px">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'to_emails')->textInput(['maxlength' => true,'value'=>$customer_email]) ?>

    <?= $form->field($model, 'cc_emails')->textInput(['maxlength' => true,'value'=>$cc_email]) ?>

    <?= $form->field($model, 'context')->textarea(['rows' => 20,'value'=>$content]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
