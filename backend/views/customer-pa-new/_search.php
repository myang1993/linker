<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPaNewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-pa-new-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'application') ?>

    <?= $form->field($model, 'application_address') ?>

    <?= $form->field($model, 'study_leadey_address') ?>

    <?= $form->field($model, 'study_leadey') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'leadey_telephone') ?>

    <?php // echo $form->field($model, 'application_email') ?>

    <?php // echo $form->field($model, 'leadey__email') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'page_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
