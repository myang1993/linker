<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Admin;
use backend\models\Trade;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\Adviser */
/* @var $form yii\widgets\ActiveForm */

$admin = new Admin();
$trade = new Trade();

?>

<div class="adviser-form cu">

<style type="text/css">
    .update-adviser-form span.edit_icon {
        color: #337ab7;
        font-size: 24px;
        vertical-align: top;
        cursor: pointer; "
    }


</style>

    <?php $form = ActiveForm::begin([

        'options' => [
            'class' => 'form-inline form update-adviser-form',
            'id' => 'update-adviser-form'
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
        'pluginOptions' => [
            'allowClear' => true, 
            'width' => '100%',
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => '/project-adviser/adviser',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression('function(params) { return {keyword:params.term}; }'),
                'processResults' => new JsExpression('function(data) {return {results: data};}')
            ],
            'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
            'templateResult' => new JsExpression('function(city) {return city.text; }'),
            'templateSelection' => new JsExpression('function (city) {return city.text; }'),
        ],
        'options' => ['placeholder' => 'Select a state ...'],
        ]
    ) ?>


    <?= $form->field($model, 'referee_fee', [
        'options' => [
            'class' => 'hide form-group'
        ]
    ])->textInput(['maxlength' => true]) ?>

    <?php if (!empty($mobile_phone)) { ?>
        <?php foreach ($mobile_phone as $index => $mp) { ?>
            <div class="form-group">
                <label>手机<?php echo $index != 0 ? $index : ''?></label>
                <input type="text" class="form-control phone" name="mobile_phone[]" value="<?php echo $mp['info']; ?>">
                <span class="glyphicon glyphicon-remove edit_icon remove_input <?php echo $index == 0 ? 'hide' : '' ?>" ></span>
            </div>
            <span class="glyphicon glyphicon-plus edit_icon add_phone <?php echo $index == 0 ? '' : 'hide' ?>"></span>
        <?php } ?>
    <?php } else { ?>
        <div class="form-group">
            <label>手机</label>
            <input type="text" class="form-control" name="mobile_phone[]">
        </div>
        <span class="glyphicon glyphicon-plus edit_icon add_phone "></span>
    <?php } ?>


    <?= $form->field($model, 'tele_phone')->textInput(['maxlength' => true]) ?>

    <?php if (!empty($email)) { ?>
        <?php foreach ($email as $index => $mp) { ?>
            <div class="form-group">
                <label>邮箱<?php echo $index != 0 ? $index : '' ?></label>
                <input type="text" class="form-control mail" name="email[]" value="<?php echo $mp['info']; ?>">
                <span class="glyphicon glyphicon-remove edit_icon remove_input <?php echo $index == 0 ? 'hide' : '' ?>" ></span>
            </div>
            <span class="glyphicon glyphicon-plus edit_icon add_mail <?php echo $index == 0 ? '' : 'hide' ?>"></span>
        <?php } ?>
    <?php } else { ?>
        <div class="form-group">
            <label>邮箱</label>
            <input type="text" class="form-control" name="email[]">
        </div>
        <span class="glyphicon glyphicon-plus edit_icon add_mail"></span>
    <?php } ?>


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

            var add_phone = $(".add_phone");
            var add_mail = $(".add_mail");
            var remove_input = $(".remove_input");
            console.log(remove_input);
            var phone_index = '.(empty($mobile_phone) ? 0 : count($mobile_phone)).';
            var mail_index = '.(empty($email) ? 0 : count($email)).';

            // 添加输入框
            function addInput(type){
                var dom = document.createElement("div");
                var label = document.createElement("label");
                var input = document.createElement("input");
                var help = document.createElement("div");
                var span = document.createElement("span");
                $(dom).addClass("form-group");

                var tmp = type == 2 ? "邮箱" : "手机";
                var len = type == 2 ? mail_index++ : phone_index++;
                $(label).text(tmp+len);

                var name = type == 2 ? "mail" : "phone";
                $(input).addClass("form-control "+ name).attr("type", "text");

                if(type == 2) {
                    $(input).attr("name", "email[]");
                }else {
                    $(input).attr("name", "mobile_phone[]");
                }

                $(help).addClass("help-block");
                $(span).addClass("glyphicon glyphicon-remove edit_icon remove_input");

                dom.append(label);
                dom.append(input);
                dom.append(span);
                dom.append(help);
                if(type == 2){
                    add_mail.after(dom);
                }else {
                    add_phone.after(dom);
                }

            }
            add_phone.on("click", function() {
                addInput(1);
            });

            add_mail.on("click", function() {
                addInput(2);
            });

            $("#update-adviser-form").on("click", function(e) {
                if(e.target.className.indexOf("remove_input") > 0) {
                    var dom = $(e.target);
                    dom.parent().remove();
                }
            });

        });'
);
?>