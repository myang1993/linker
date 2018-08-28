<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" style="text-align: center;">
    <div class="highlight box" style="width: 400px; margin-top: 100px; display: inline-block;">
        <h1><?= Html::encode($this->title) ?></h1>

        <!-- <p>Please fill out the following fields to login</p> -->

        <div class="row">
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => [
                            'class' => 'form-inline form',
                        ],
                    ]); ?>

                    <?= $form->field($model, 'username', [
                            'options' => [
                                'style' => 'margin:20px 0 10px 0;'
                            ]
                        ])->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password', [
                            'options' => [
                                'style' => 'margin:20px 0 10px 0;'
                            ]
                        ])->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group form-group-block form-group-btn">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
