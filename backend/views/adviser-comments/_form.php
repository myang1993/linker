<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdviserComments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adviser-comments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comments')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_uid')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
