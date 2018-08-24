<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Area;
use backend\models\Trade;
/* @var $this yii\web\View */
/* @var $model backend\models\AdviserSearch */
/* @var $form yii\widgets\ActiveForm */

$area = new Area();
$trade = new Trade();
?>

<div class="adviser-search search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=> [
            'class'  => 'form-inline form',
            'data-pjax' => 1
        ]
    ]); ?>

    <?= $form->field($model, 'province')->dropDownList(
        $area->getAreaList(),
        [
            'prompt' => '--请选择省--',
        ])
    ?>

    <?= $form->field($model, 'city')->dropDownList(
        [],
        [
            'prompt' => '--请选择市--',
        ]
    ) ?>

    <?= $form->field($model, 'trade')->dropDownList(
        $trade->getTradeList(0),
        [
            'prompt' => '--请选择行业--',
        ])
    ?>

    <?= $form->field($model, 'child_trade')->dropDownList(
        [],
        [
            'prompt' => '--请选择子行业--',
        ]
    ) ?>

    <div class="form-group" style="vertical-align: top;">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(
    '$(document).ready(function(){
            var province = $("#advisersearch-province");
            var city = $("#advisersearch-city");
            var trade = $("#advisersearch-trade");
            var child_trade = $("#advisersearch-child_trade");
            var filter_province = ["110000", "120000", "310000", "500000"];

            //ajax获取数据
            function ajaxData(target, url, params){
                $.post("/"+url+"?"+params,function(data){
                    console.log(data);
                    target.html(data);
                });
            }

            function addContent(str, dom, target, url, typeid){
                dom.on("change", function(){
                    var tmp = $(this).val();
                    var tid = 1;
                    if(tmp){
                        if(str == "province" && filter_province.indexOf(tmp) > -1){
                            tid = 2;
                            tmp = +tmp + 100 + "";
                        }
                        ajaxData(target, url, typeid+"="+tid+"&pid="+tmp)
                    }else {
                        var tmp_str = "";
                        if(str == "province") {
                            tmp_str = "<option value=\"\">--请选择市区--</option>";
                        }
                        if(str == "trade") {
                            tmp_str = "<option value=\"\">--请选择子行业--</option>";
                        }
                        target.html(tmp_str);
                    }
                })
            }

            function init(){
                var val1 = province.val();
                var val2 = trade.val();
                var tid = 1;
                if(val1){
                    if(filter_province.indexOf(val1) > -1){
                        tid = 2;
                        val1 = +val1 + 100 + "";
                    }
                    ajaxData(city, "adviser/site", "typeId="+tid+"&pid="+val1)
                }

                if(val2){
                    tid = 1;
                    ajaxData(child_trade, "trade/list", "typeid="+tid+"&pid="+val2);
                }
                addContent("province", province, city, "adviser/site", "typeId");
                addContent("trade", trade, child_trade, "trade/list", "typeid");
            }
            init();
        });'
);
?>