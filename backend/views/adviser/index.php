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
?>
<div class="adviser-index list">

    <h3 class="title"><?= Html::encode($this->title) ?></h3>
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
            <!-- <div class="form-group row">
                <label for="project_list" class="col-sm-2 col-form-label">项目</label>
                <div class="col-sm-8">
                    <select type="text" class="form-control" id="project_list" placeholder="Enter email"></select>
                </div>
            </div> -->
            <?= DetailView::widget([
                'model' => $searchModel,
                'condensed' => true,
                'hover' => true,
                'mode' => DetailView::MODE_EDIT,
                'container' => ['id' => 'add_project_modal'],
                

                'attributes' => [
                
                    [
                        'label' => '项目',
                        'attribute' => 'name_zh',
                        'format' => 'raw',
                        'type' => DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'modal2-adviser-id', 'placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        'widgetOptions' => [
                            // 'data' => $adviser->getAdviser(),
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width' => '100%',
                                'minimumInputLength' => 2,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => '/project/get-project',
                                    'dataType' => 'json',
                                    'delay' => 250,
                                    'data' => new JsExpression('function(params) { return {keyword:params.term}; }'),
                                    'processResults' => new JsExpression('function(data) {return {results: data.data};}')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
                                'templateResult' => new JsExpression('function(city) {return city.name; }'),
                                'templateSelection' => new JsExpression('function (city) {return city.name; }'),

                            ],
                        ],
                        'valueColOptions' => ['style' => 'width:60%']
                    ]
                ]

            ]); ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-save">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        <?php Modal::end(); ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['id' => 'adviser_list'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            [
                'attribute' => 'name_zh',
                'format' => 'raw',
                'contentOptions' => [
                    'style' => 'min-width: 60px;'
                ],
                'value' => function($data){
                    return Html::a($data->name_zh, "/adviser/view?id=".$data->id);
                }
            ],
            [
                'attribute' => 'company',
                'contentOptions' => [
                    'style' => 'min-width: 60px;'
                ]
            ],
            [
                'attribute' => 'position',
                'contentOptions' => [
                    'style' => 'min-width: 60px;'
                ]
            ],
            [
                'attribute' => 'mobile_phone',
            ],
            [
                'attribute' => 'describe',
            ],
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
                // 'filter' => [],
            ],
            [
                'attribute' => 'update_time',
                'value' => function($data){
                    return date('Y-m-d H:i', $data->update_time);
                },
                'contentOptions' => [
                    'style' => 'min-width: 130px;'
                ]
            ],
            [
                'attribute' => 'remark',
            ],
            [
                'attribute' => 'times',
                'contentOptions' => [
                    'style' => 'min-width: 80px;'
                ]
            ],
            [
                'attribute' => 'operator',
                'contentOptions' => [
                    'style' => 'min-width: 130px;'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
    $this->registerJs('
        $(document).ready(function(){
            var store = "";
            
            //save
            $(".modal-save").on("click", function(){
                var p_id = $("#modal2-adviser-id").val();
                console.log(store, typeof store);
                $.ajax({
                    url: "/adviser/add-adviser-project",
                    dataType: "json",
                    method: "GET",
                    data: {
                        "adviser_list": store,
                        "project_id": p_id
                    },
                    success: function(data){
                        if(window.localStorage){
                            localStorage.setItem("box_list", "");
                        }
                        $("#add_project_modal").modal("hide");
                    },
                    error: function(data){
                        console.log(data);
                    }
                });


            });

            //点击添加按钮
            $(".add_button").on("click", function () {
                //支持localStorage
                var tmp_arr = $("#adviser_list").yiiGridView("getSelectedRows");
                var tmp_ls = window.localStorage ? localStorage.getItem("box_list") : "";

                if(tmp_ls){
                    tmp_ls = tmp_ls.split(",");
                }

                store = tmp_ls ? tmp_ls.concat(tmp_arr) : tmp_arr;
                
                if(!store.length) {
                    alert("请选择顾问");
                    return false;
                }

            });

            //点击分页添加localstorage
            $(".pagination").on("click", function(){
                var keys = $("#adviser_list").yiiGridView("getSelectedRows");
                //支持localStorage
                if(window.localStorage) {
                    var row_list = localStorage.getItem("box_list");
                    if(keys.length > 0){
                        if(!row_list){
                            row_list = "";
                        }
                        console.log(row_list);
                        store = row_list ? keys.join(",")+","+row_list : keys.join(",");
                        localStorage.setItem("box_list", store);
                    }
                }
            });


        })

    ');
?>