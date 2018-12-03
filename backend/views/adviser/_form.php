<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Admin;
use backend\models\Trade;
/* @var $this yii\web\View */
/* @var $model backend\models\Adviser */
/* @var $form yii\widgets\ActiveForm */

$admin = new Admin();
$trade = new Trade();

?>

<div class="adviser-form cu">

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

    <?= $form->field($model, 'name_zh')->textInput(['maxlength' => true, 'required' => 'required', 'style' => 'min-width: 100px;']) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->dropDownList(
        $area->getAreaList(),
        [
            'prompt' => '--请选择省--',
            'onchange' => '
            $(".form-group.field-adviser-district").hide();
            var val = $(this).val();
            var tmp_arr = ["110000", "120000", "310000", "500000"];
            if(tmp_arr.indexOf(val) > -1){
                val = +val + 100 + "";
            }
            $.post("' . yii::$app->urlManager->createUrl('adviser/site') . '?typeId=1&pid="+val,function(data){
                $("select#adviser-city").html(data);
            });',
        ]
    ) ?>

    <?= $form->field($model, 'city')->dropDownList(
        [],
        [
            'prompt' => '--请选择市区--',
            'onchange' => '
                $(".form-group.field-adviser-district").show();
                $.post("' . yii::$app->urlManager->createUrl('adviser/site') . '?typeId=2&pid="+$(this).val(),function(data){
                    $("select#adviser-district").html(data);
                });',
        ]
    ) ?>

    
    <?= $form->field($model, 'trade')->widget(Select2::classname(), [
        'data' => $trade->getTradeList(0),
        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        'options' => ['placeholder' => 'Please select ...', 'id' => 'select_trade'],
        'pluginEvents' => [
            'change' => 'function(){
                $.post("' . yii::$app->urlManager->createUrl('trade/list') . '?typeid=0&pid="+$(this).val(),function(data){
                    console.log(data);
                    $("select#select_child_trade").html(data);
                })
            }',
        ]
    ]
    ) ?>

    <?= $form->field($model, 'child_trade')->widget(Select2::classname(), [
        'data' => $trade->getTradeList($model->trade),
        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        'options' => ['placeholder' => 'Please select ...', 'id' => 'select_child_trade'],
    ]
    ) ?>

    <?= $form->field($model, 'source_type')->hiddenInput()->dropDownList(
        $model->SourceType(),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
            'required' => 'required'
        ]
    ) ?>
    <?= $form->field($model, 'referee', [
        'options' => [
            'class' => 'hide form-group'
        ]
    ])->widget(Select2::classname(), [
        'data' => $model->getAdviser(),
        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        'options' => ['placeholder' => 'Select a state ...'],
        ]
    ) ?>
    <?= $form->field($model, 'referee_fee', [
        'options' => [
            'class' => 'hide form-group'
        ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true, 'required' => 'required']) ?>

    <?= $form->field($model, 'tele_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'linkedin')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tax_type')->hiddenInput()->dropDownList(
        $model->taxType(),
        [
            'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
            'required' => 'required'
        ]
    ) ?>
    <div class="form-group-block form-group">
        <?= $form->field($model, 'fee_phone')->textInput(['required' => 'required']) ?>
        <?= $form->field($model, 'fee_phone_type')->hiddenInput()->dropDownList(
            $model->priceType(),
            [
                'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
                'required' => 'required'
            ]
        )->label(false) ?>
    </div>

    <div class="form-group-block form-group">
        <?= $form->field($model, 'fee_road')->textInput(['required' => 'required']) ?>
        <?= $form->field($model, 'fee_road_type')->hiddenInput()->dropDownList(
            $model->priceType(),
            [
                'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
                'required' => 'required'
            ]
        )->label(false) ?>
    </div>

    <div class="form-group-block form-group">
        <?= $form->field($model, 'fee_face')->textInput(['required' => 'required']) ?>
        <?= $form->field($model, 'fee_face_type')->hiddenInput()->dropDownList(
            $model->priceType(),
            [
                'prompt' => '-- ' . Yii::t('app', 'Please select') . " --",
                'required' => 'required'
            ]
        )->label(false) ?>
    </div>

    <div class="form-group-block form-group">
         <?= $form->field($model, 'operator')->widget(Select2::classname(), [
            'data' => $admin->getAdminList(),
            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
            'options' => ['placeholder' => 'Please select ...', 'id' => 'select_operator'],
        ]
    ) ?>
    </div>

    <div class="hr"></div>

    <h3 class="title"><?= Yii::t('app', 'Career') ?></h3>

    <?= $form->field($model, 'company', [
        'options' => [
            'class' => 'form-group form-group-block'
        ]
    ])->textInput(['maxlength' => true, 'class' => 'form-control form-field-5', 'required' => 'required']) ?>

    <?= $form->field($model, 'position', [
        'options' => [
            'class' => 'form-group form-group-block'
        ]
    ])->textInput(['maxlength' => true, 'class' => 'form-control form-field-5', 'required' => 'required']) ?>

    <?= $form->field($model, 'describe', [
        'options' => [
            'class' => 'form-group form-group-block ht_2'
        ]
    ])->textArea(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <?= $form->field($model, 'expertise', [
        'options' => [
            'class' => 'form-group form-group-block ht_2'
        ]
    ])->textArea(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <?= $form->field($model, 'profile', [
        'options' => [
            'class' => 'form-group form-group-block ht_2'
        ]
    ])->textArea(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <div class="hr"></div>

    <h3 class="title"><?= Yii::t('app', 'Bank card Information') ?></h3>

    <?= $form->field($model, 'bank_card_no', [
        'options' => [
            'class' => 'form-group form-group-block'
        ]
    ])->textInput(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <?= $form->field($model, 'bank_card_addr', [
        'options' => [
            'class' => 'form-group form-group-block'
        ]
    ])->textInput(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <?= $form->field($model, 'bank_card_name', [
        'options' => [
            'class' => 'form-group form-group-block'
        ]
    ])->textInput(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <?= $form->field($model, 'pay_remark', [
        'options' => [
            'class' => 'form-group form-group-block'
        ]
    ])->textInput(['maxlength' => true, 'class' => 'form-control form-field-5']) ?>

    <div class="form-group form-group-block form-group-btn">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(
    '$(document).ready(function(){
            var source_type = $("#adviser-source_type");
            var referee = $(".field-adviser-referee");
            var referee_fee = $(".field-adviser-referee_fee");
            if(source_type.val() == 3) {
                referee.removeClass("hide");
                referee_fee.removeClass("hide");
            }

            source_type.on("change", function(){
                if($(this).val() == 3) {
                    referee.removeClass("hide");
                    referee_fee.removeClass("hide");
                }else {
                    referee.addClass("hide");
                    referee_fee.addClass("hide");
                }
            });


            var province = $("#adviser-province");
            var city = $("#adviser-city");
            var filter_province = ["110000", "120000", "310000", "500000"];

            //ajax获取数据
            function ajaxData(target, url, params){
                $.post("/"+url+"?"+params,function(data){
                    if(data){
                        if(data.indexOf('.$model->city.') > -1) {
                            var pos = data.indexOf('.$model->city.') + 6 + 1;
                            data = data.slice(0, pos) + " selected" + data.slice(pos);
                        }
                    }
                    target.html(data);
                });
            }

            (function init(){
                var val = province.val();
                var tid = 1;
                if(val){
                    if(filter_province.indexOf(val) > -1){
                        tid = 2;
                        val = +val + 100 + "";
                    }
                    ajaxData(city, "adviser/site", "typeId="+tid+"&pid="+val)
                }
            })();



        });'
);
?>