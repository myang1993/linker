<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerBoffin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-boffin-form cu">

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

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'name_zh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tele_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'linkedin')->textInput(['maxlength' => true]) ?>

    <div class="form-group form-group-block form-group-btn">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
