<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-item-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=> [
            'class'  => 'form-inline',
        ]
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'trade_name') ?>

    <?= $form->field($model, 'tradeParent_name') ?>

    <div class="form-group form-group-btn">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
