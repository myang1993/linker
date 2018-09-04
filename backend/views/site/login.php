<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login">
    <div class="box">
        <h3><?= Html::encode($this->title) ?></h3>

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
                                'class' => 'input_outer'
                            ]
                        ])->textInput([
                            'autofocus' => true,
                            'placeholder' => '请输入账户',
                            'autocomplete' => 'off',
                        ])->label(false) ?>

                    <?= $form->field($model, 'password', [
                            'options' => [
                                'class' => 'input_outer'
                            ]
                        ])->passwordInput([
                            'placeholder' => '请输入密码',
                            'autocomplete' => 'off',
                        ])->label(false) ?>

                    <?= $form->field($model, 'rememberMe', [
                        'options' => [
                                'class' => 'check_outer'
                            ]
                    ])->checkbox() ?>

                    <div class="form-group login-button">
                        <?= Html::submitButton('登录', ['class' => 'btn', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
