<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'to_emails') ?>

    <?= $form->field($model, 'cc_emails') ?>

    <?= $form->field($model, 'bcc_emails') ?>

    <?= $form->field($model, 'context') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
