<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Area;
use backend\models\Trade;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\detail\DetailView;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdviserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Advisers');
$this->params['breadcrumbs'][] = $this->title;
$area = new Area();
$trade = new Trade();
$project = new \backend\models\Project();
?>
<div class="adviser-index list">

    <!-- <h3 class="title"><?= Html::encode($this->title) ?></h3> -->
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Adviser'), ['create'], ['class' => 'btn btn-success']) ?>


        <?php Modal::begin([
            'header' => '<h4 class="modal-title text-center"><strong>选择项目</strong></h4>',
            'id' => 'add-advisers',
            'toggleButton' => ['label' => '添加顾问到项目', 'class' => 'btn btn-primary add_button'],
            'options' => ['tabindex' => false]
        ]); ?>
            <?= DetailView::widget([
                'model' => $searchModel,
                'condensed' => true,
                'hover' => true,
                'mode' => DetailView::MODE_EDIT,
                'container' => [
                    'id' => 'add_project_modal',

                ],
                'attributes' => [
                
                    [
                        'label' => '项目',
                        'attribute' => 'name_zh',
                        'format' => 'raw',
                        'type' => DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'modal2-project-id', 'placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        'widgetOptions' => [
                            'data' => $project->getProject(),
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width' => '100%',
//                                'minimumInputLength' => 2,
//                                'language' => [
//                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
//                                ],
//                                'ajax' => [
//                                    'url' => '/project/get-project',
//                                    'dataType' => 'json',
//                                    'delay' => 250,
//                                    'data' => new JsExpression('function(params) { return {keyword:params.term}; }'),
//                                    'processResults' => new JsExpression('function(data) {return {results: data.data};}')
//                                ],
//                                'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
//                                'templateResult' => new JsExpression('function(city) {return city.name; }'),
//                                'templateSelection' => new JsExpression('function (city) {return city.name; }'),

                            ],
                        ],
                        'valueColOptions' => ['style' => 'width:60%']
                    ]
                ]

            ]); ?>
            <div class="has-error text-center" style="font-size: 18px;"><p class="modal_tip help-block help-block-error"></p></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-save" id="modal-save">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        <?php Modal::end(); ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => ['id' => 'adviser_list'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            [
                'attribute' => 'name_zh',
                'format' => 'raw',
                'contentOptions' => function($data){
                    $arr = [];
                    $arr['title'] = $data->name_zh;
                    $arr['style'] = 'max-width: 80px';
                    return $arr;
                },
                'value' => function($data){
                    return Html::a($data->name_zh, "/adviser/view?id=".$data->id);
                }
            ],
            [
                'attribute' => 'company',
                'contentOptions' => [
                    'style' => 'max-width: 120px;'
                ]
            ],
            [
                'attribute' => 'position',
                'contentOptions' => [
                    'style' => 'max-width: 120px;'
                ]
            ],
//            [
//                'attribute' => 'mobile_phone',
//            ],
            [
                'attribute' => 'describe',
                'contentOptions' => function($data){
                    $arr = [];
                    $arr['title'] = $data->describe;
                    // $arr['style'] = 'white-space: initial;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;overflow: hidden;';
                    return $arr;
                }

            ],
//            [
//                'attribute' => 'expertise',
//                'contentOptions' => function($data){
//                    $arr = [];
//                    $arr['title'] = $data->expertise;
//                    return $arr;
//                }
//            ],
//            [
//                'attribute' => 'profile',
//                'contentOptions' => function($data){
//                    $arr = [];
//                    $arr['title'] = $data->profile;
//                    return $arr;
//                }
//            ],
            [
                'label' => Yii::t('app', '省份'),
                'attribute' => 'province_name',
                'value' => function($model){
                    return $model->province ? Area::findOne($model->province)->name: '';
                },
                // 'filter' => $area->getAreaList(),
            ],
            [
                'label' => Yii::t('app', '市'),
                'attribute' => 'city_name',
                'value' => function($model){
                    return $model->city ? Area::findOne($model->city)->name : '';
                },
                // 'filter' => [],
            ],
            [
                'label' => Yii::t('app', '行业'),
                'attribute' => 'trade_name',
                'value' => function($model){
                    return $model->trade ? Trade::findOne($model->trade)->name: '';
                },
                // 'filter' => $trade->getTradeList(0),
            ],
            [
                'label' => Yii::t('app', '子行业'),
                'attribute' => 'child_trade_name',
                'value' => function($model){
                    return $model->child_trade ? Trade::findOne($model->child_trade)->name: '';
                },
                'contentOptions' => [
                    'style' => 'max-width: 140px;'
                ]
                // 'filter' => [],
            ],
//            [
//                'attribute' => 'update_time',
//                'value' => function($data){
//                    return date('Y-m-d H:i', $data->update_time);
//                },
//                'contentOptions' => [
//                    'style' => 'min-width: 130px;'
//                ]
//            ],
            [
                'label' => 'Comments',
                'value' => function ($data) {
                    return \app\models\AdviserComments::getNewComments($data->id) ? \app\models\AdviserComments::getNewComments($data->id)->comments : '';
                },
            ],
            [
                'attribute' => 'times',
                'contentOptions' => [
                    'style' => 'max-width: 60px;'
                ]
            ],
//            [
//                'attribute' => 'operator',
//                'contentOptions' => [
//                    'style' => 'min-width: 130px;'
//                ]
//            ],
           [
               'class' => 'yii\grid\ActionColumn',
               'template' => '{delete}',
           ],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{update}',
//            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
    $this->registerJs('
        $(document).ready(function(){
            var store = [];
            if(window.localStorage){
                if(localStorage.getItem("box_list_time") && new Date().getTime() - localStorage.getItem("box_list_time") > 1000*60*60){
                    localStorage.setItem("box_list", "");
                    localStorage.setItem("box_list_time", "");
                }
                var old_store = localStorage.getItem("box_list");
                var tmp_store = old_store ? old_store.split(",") : "";
                if(old_store){
                    $("#adviser_list").find("tbody tr").map(function(item){
                        var v = $(this).attr("data-key");
                        if(tmp_store.indexOf(v) > -1) {
                            store.push(v);
                            $(this).find("input:checkbox").attr("checked", "checked")
                        }
                    });
                }
            }

            //save
            $(".adviser-index").on("click", "#modal-save", function(){
                var p_id = $("#modal2-project-id").val();
                //删除空数组
                store = store.filter(function(n){return n});
                $.ajax({
                    url: "/adviser/add-adviser-project",
                    dataType: "json",
                    method: "GET",
                    data: {
                        "adviser_list": store,
                        "project_id": p_id
                    }
                }).done(function(data){
                    if(data.status == 0){
                        if(window.localStorage){
                            localStorage.setItem("box_list", "");
                            localStorage.setItem("box_list_time", "");
                        }
                        $("#add-advisers").modal("hide");
                        window.location.reload();
                    }else{
                        $(".modal_tip").text(data.message);
                    }
                });
            });

            //点击checkbox
            $(".adviser-index").on("click", "#adviser_list table", function(e){
                var target = e.target;
                if(target && $(target).attr("type") == "checkbox" ){
                    var v = $(target).val()+"";
                    var tmp_ls = window.localStorage ? localStorage.getItem("box_list") : "";
                    if(store.indexOf(v) == -1){
                        store.push(v);
                    }else {
                        var index = store.indexOf(v);
                        store.splice(index, 1);
                        var tmp = tmp_ls.replace(v, "");
                        localStorage.setItem("box_list", tmp);
                    }
                    console.log(store);
                }
            });

            //点击添加按钮
            $(".add_button").on("click", function () {
                //支持localStorage
                var tmp_ls = window.localStorage ? localStorage.getItem("box_list") : "";

                if(tmp_ls){
                    tmp_ls = tmp_ls.split(",");
                }

                store = tmp_ls ? tmp_ls.concat(store) : store;
                console.log(store);
                if(!store.length) {
                    alert("请选择顾问");
                    return false;
                }

            });

            //点击分页添加localstorage
            $(".adviser-index").on("click", ".pagination", function(){
                //支持localStorage
                if(window.localStorage) {
                    var tmp_ls = window.localStorage ? localStorage.getItem("box_list") : "";
                    if(store.length > 0) {
                        var tmp = store.filter(function(item){
                            if(tmp_ls.indexOf(item) == -1) {
                                return item;
                            }
                        })
                        console.log("----", tmp);
                        store = tmp_ls ? tmp_ls + "," + tmp.join(",") : tmp.join(",");
                        if(!localStorage.getItem("box_list")){
                            localStorage.setItem("box_list_time", new Date().getTime())
                        }
                        localStorage.setItem("box_list", store);
                    }
                }
            });


        })

    ');
?>