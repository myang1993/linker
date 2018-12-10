<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-log-form" style="margin-top: 50px">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'to_emails')->textInput(['maxlength' => true, 'placeholder'=>'多个邮箱已分号分割']) ?>

    <?= $form->field($model, 'cc_emails')->textInput(['maxlength' => true, 'placeholder'=>'多个邮箱已分号分割']) ?>


    <?= $form->field($model, 'content')->label(false)->widget('kucha\ueditor\UEditor', [
        'clientOptions' => [
            //编辑区域大小
            'initialFrameHeight' => '300',
            //设置语言
            'lang' => 'zh-cn', //中文为 zh-cn
            //定制菜单
            'toolbars' => [
                    [
                        'fullscreen', 'source', 'undo', 'redo', '|',
                        'fontsize',
                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                        'forecolor', 'backcolor', '|',
                        'lineheight', '|',
                        'indent', '|'
                    ],
            ],
        ],
        'id'=>'content',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('发送', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
