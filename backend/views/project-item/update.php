<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectItem */
/* @var $form yii\widgets\ActiveForm */

$trade = new backend\models\Trade();
$adviser = new backend\models\Adviser();
$customer = new backend\models\Customer();
$status = new backend\models\ProjectStatus();

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectItem */

$this->title = Yii::t('app', 'Update Project Item: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="project-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trade_parent_id')->dropDownList(
        $trade->getTradeList(0),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
            'onchange' => '
                $.post("' . yii::$app->urlManager->createUrl('trade/list') . '&typeid=1&pid="+$(this).val(),function(data){
                    $("select#projectitem-trade_id").html(data);
                });',
        ]
    ) ?>

    <?= $form->field($model, 'trade_id')->hiddenInput()->dropDownList(
        $trade->getTradeList($model->trade_parent_id),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
        ]
    ) ?>

    <?= $form->field($model, 'status')->hiddenInput()->dropDownList(
        $status->getStatusList(),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
        ]
    ) ?>

    <?php
    foreach ($proadcu as $key => $value) {
        ?>

        <?= $form->field($value, '[' . $key . ']id')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($value, '[' . $key . ']customer_id')->hiddenInput()->dropDownList(
            $customer->getCustomerList(),
            [
                'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
            ]
        ) ?>

        <?= $form->field($value, '[' . $key . ']adviser_id')->hiddenInput()->dropDownList(
            $adviser->getAdviserList(),
            [
                'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
            ]
        ) ?>
        <?php

    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
