<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Trade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trade-form cu">
	<div class="highlight">
	<h3 class="title">添加父行业</h3>
    <?php $form = ActiveForm::begin([
 				'options' => [
            'class' => 'form-inline form',
        ],

        'fieldConfig' => [  // 为每一个input 设置
            'template' => "{label}{input}{error}",
            // <label></label> \n <div class="..."> <input ...> </div>\n<div class=\"col-lg-5\">这个是yii默认的错误提示</div>
            'labelOptions' => ['class' => ''],    // 设置label 的属性 添加class
        ],
    ]); ?>

    <?= $form->field($model, 'parent_id')->textInput()->hiddenInput(['value'=>0])->label(false) ?>
    <?= $form->field($model, 'name')->textInput()->label('名称') ?>


    <div class="form-group form-group-block form-group-btn">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	</div>

	<div class="highlight">
		<h3 class="title">添加子行业</h3>
    <?php $form = ActiveForm::begin([
 				'options' => [
            'class' => 'form-inline form',
        ],

        'fieldConfig' => [  // 为每一个input 设置
            'template' => "{label}{input}{error}",
            // <label></label> \n <div class="..."> <input ...> </div>\n<div class=\"col-lg-5\">这个是yii默认的错误提示</div>
            'labelOptions' => ['class' => ''],    // 设置label 的属性 添加class
        ],
    ]); ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => $model->getTradeList(0),
        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        'options' => ['placeholder' => 'Please select ...', 'id' => 'select_parent_id'],
        ]
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group form-group-block form-group-btn">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	</div>

</div>
