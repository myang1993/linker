<?php

use yii\helpers\Html;
use backend\models\Area;
use backend\models\Trade;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\detail\DetailView;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model backend\models\Adviser */
$project = new \backend\models\Project();
$this->title = $model->name_zh;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advisers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="adviser-view view">
        <div class="box highlight">
            <h3 class="title">
                <?= Html::encode($this->title) ?>
                <?= Html::a('', '/adviser/update?id=' . $model->id, [
                    'class' => 'glyphicon glyphicon-pencil pull-right',
                    'style' => 'margin-left:50px;'
                ]) ?>
                <?= Html::a('参与的项目', '/project/index?ProjectSearch[adviser_name]=' . $this->title, [
                    'class' => 'btn btn-primary add_button pull-right',
                    'style' => 'margin-left:50px;',
                    'target' => '_blank;'
                ]) ?>
                <?php Modal::begin([
                    'header' => '<h4 class="modal-title text-center"><strong>选择项目</strong></h4>',
                    'id' => 'add-advisers',
                    'toggleButton' => ['label' => '添加到项目', 'class' => 'btn btn-primary add_button pull-right'],
                    'options' => ['tabindex' => false]
                ]); ?>
                <?= DetailView::widget([
                    'model' => $model,
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
                            'options' => ['id' => 'modal2-project-id', 'placeholder' => '-- ' . Yii::t('app', 'Please select')],
                            'widgetOptions' => [
                                'data' => $project->getProject(),
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width' => '100%',
                                    // 'minimumInputLength' => 2,
                                    // 'language' => [
                                    //     'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    // ],
                                    // 'ajax' => [
                                    //     'url' => '/project/get-project',
                                    //     'dataType' => 'json',
                                    //     'delay' => 250,
                                    //     'data' => new JsExpression('function(params) { return {keyword:params.term}; }'),
                                    //     'processResults' => new JsExpression('function(data) {return {results: data.data};}')
                                    // ],
                                    // 'escapeMarkup' => new JsExpression('function (markup) {return markup; }'),
                                    // 'templateResult' => new JsExpression('function(city) {return city.name; }'),
                                    // 'templateSelection' => new JsExpression('function (city) {return city.name; }'),

                                ],
                            ],
                            'valueColOptions' => ['style' => 'width:60%']
                        ]
                    ]

                ]); ?>
                <div class="has-error text-center" style="font-size: 18px;"><p
                            class="modal_tip help-block help-block-error"></p></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                <?php Modal::end(); ?>
            </h3>

<style type="text/css">
    .adviser_info.box .form-group {
        min-width: 400px;
    }
    .adviser_info.box .form-group p {
        margin-bottom: 0;
    }
</style>
            <div class="adviser_info box form-inline" style="padding: 20px 0;overflow: hidden;">
                <div class="form-group">
                    <label class="control-label text-center">中文姓名:</label>
                    <p class="form-control-static"><?php echo $model->name_zh ?></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-center">英文姓名:</label>
                    <p class="form-control-static"><?php echo $model->name_en ?></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-center">地址:</label>
                      <p class="form-control-static"><?php echo ($model->province ? Area::findOne($model->province)->name . ' ' : ' ') . ($model->city ? Area::findOne($model->city)->name . ' ' : ' ') . ($model->district ? Area::findOne($model->district)->name : ' ') ?></p>
                </div>
                <div class="form-group">
                    <label class=" control-label text-center">行业:</label>
                      <p class="form-control-static"><?php echo ($model->trade ? Trade::findOne($model->trade)->name . ' ' : ' ') . ($model->child_trade ? Trade::findOne($model->child_trade)->name . ' ' : ' ') ?></p>
                </div>
                <div class="form-group">
                    <label class=" control-label text-center" >顾问来源:</label>
                      <p class="form-control-static"><?php echo $model->source_type == 0 ? '' : $model->SourceType($model->source_type) ?></p>
                </div>
                <div class="form-group <?php echo $model->source_type == 3 ? '' : 'hide'?>">
                    <label class="control-label text-center ">推荐人:</label>
                      <p class="form-control-static"><?php echo $model->getInfo(intval($model->referee)) ?></p>
                </div>
                <div class="form-group <?php echo $model->source_type == 3 ? '' : 'hide'?>">
                    <label class="control-label text-center">推荐费:</label>
                      <p class="form-control-static"><?php echo $model->referee_fee ?></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-center">手机:</label>
                      <p class="form-control-static"><?php echo $model->mobile_phone ?></p>
                </div>
                <div class="form-group">
                    <label class=" control-label text-center">座机:</label>
                      <p class="form-control-static"><?php echo $model->tele_phone ?></p>
                </div>
                <div class="form-group">
                    <label class=" control-label text-center">邮箱:</label>
                      <p class="form-control-static"><?php echo $model->email ?></p>
                </div>
                <div class="form-group">
                    <label class="control-label text-center">微信:</label>
                      <p class="form-control-static"><?php echo $model->wechat ?></p>
                    </div>
                <div class="form-group">
                    <label class="control-label text-center">领英:</label>
                      <p class="form-control-static"><?php echo $model->linkedin ?></p>
                    </div>
                <div class="form-group">
                    <label class="control-label text-center">纳税类型:</label>
                      <p class="form-control-static"><?php echo $model->tax_type == 0 ? '' : $model->taxType($model->tax_type) ?></p>
                    </div>
                <div class="form-group">
                    <label class=" control-label text-center">电话访谈费率:</label>
                      <p class="form-control-static"><?php echo $model->fee_phone . "（" . ($model->fee_phone_type == 0 ? '' : $model->priceType($model->fee_phone_type)) . "）" ?></p>
                    </div>
                <div class="form-group">
                    <label class="control-label text-center">路演访谈费率:</label>
                      <p class="form-control-static"><?php echo  $model->fee_road . "（" . ($model->fee_road_type == 0 ? '' : $model->priceType($model->fee_road_type)) . "）" ?></p>
                    </div>
                <div class="form-group">
                    <label class="control-label text-center">面谈访谈费率:</label>
                      <p class="form-control-static"><?php echo $model->fee_face . "（" . ($model->fee_face_type == 0 ? '' : $model->priceType($model->fee_face_type)) . "）" ?></p>
                    </div>
                <div class="form-group">
                    <label class=" control-label text-center">首次录入人员:</label>
                      <p class="form-control-static"><?php echo $model->operator ?></p>
                    </div>
                <div class="form-group">
                    <label class=" control-label text-center">合作次数:</label>
                      <p class="form-control-static"><?php echo $model->times ?></p>
                    </div>                    
                </div>
            </div>

            <div class="hr"></div>

            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '',
                'columns' => [
                    'comments',
                    [
                        'attribute' => 'comment_uid',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->admin->username;
                        },
                    ],
                    'create_time',
                ],
            ]); ?>

            <?php
            $adviserComments = new \app\models\AdviserComments();
            $adviserComments->adviser_id = $model->id;
            $adviserComments->comment_uid = Yii::$app->user->id;
            $adviserComments->create_time = date('Y-m-d H:i:s');
            ?>

            <?php Modal::begin([
                'header' => '<h4 class="modal-title" style="1000px">' . '添加备注' . '</h4>',
                'toggleButton' => ['label' => '<i class="glyphicon glyphicon-plus"></i>' . '添加备注', 'class' => 'btn btn-primary'],
                'options' => ['style' => 'height:1000px']

            ]); ?>
            <?= DetailView::widget([
                'model' => $adviserComments,
                'condensed' => true,
                'hover' => true,
                'mode' => DetailView::MODE_EDIT,
                'container' => ['id' => 'kv-demo'],
                'panel' => [
                    'heading' => '',
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [
                    [
                        'label' => '专家',
                        'value' => $model->name_zh,
                        'options' => ['id' => 'modal1-boffin-name_en'],
                        'displayOnly' => true,
                    ],
                    [
                        'attribute' => 'adviser_id',
                        'value' => $model->id,
                        'type' => DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute' => 'comment_uid',
                        'type' => DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute' => 'create_time',
                        'type' => DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute' => 'comments',
                        'options' => ['id' => 'modal2-remark'],
                        'type' => DetailView::INPUT_TEXTAREA,
                    ],
                ],
                'formOptions' => [
                    'action' => \yii\helpers\Url::toRoute(['adviser-comments/create']),
                ],
            ]); ?>
            <?php Modal::end(); ?>

            <div class="hr"></div>

            <h3 class="title"><?= Yii::t('app', 'Career') ?></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'company',
                    'position',
                    'describe',
                    'expertise',
//                    'profile',
                ],
                'options' => ['class' => 'table table-hover table-noborder']
            ]) ?>

            <div class="hr"></div>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataAdviserResume,
                'summary' => '',
                'columns' => [
                    'company',
                    'position',
                    'begin_time',
                    'end_time',
                    'create_time',
//                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php
            $adviserResume = new \app\models\AdviserResume();
            $adviserResume->adviser_id = $model->id;
            $adviserResume->create_time = date('Y-m-d H:i:s');
            ?>

            <?php Modal::begin([
                'header' => '<h4 class="modal-title" style="1000px">' . '添加简历' . '</h4>',
                'toggleButton' => ['label' => '<i class="glyphicon glyphicon-plus"></i>' . '添加简历', 'class' => 'btn btn-primary'],
                'options' => ['style' => 'height:1000px']

            ]); ?>
            <?= DetailView::widget([
                'model' => $adviserResume,
                'condensed' => true,
                'hover' => true,
                'mode' => DetailView::MODE_EDIT,
                'container' => ['id' => 'kv-demo'],
                'panel' => [
                    'heading' => '',
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [
                    [
                        'label' => '专家',
                        'value' => $model->name_zh,
                        'options' => ['id' => 'modal1-boffin-name_en'],
                        'displayOnly' => true,
                    ],
                    [
                        'attribute' => 'adviser_id',
                        'value' => $model->id,
                        'type' => DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute' => 'create_time',
                        'type' => DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute' => 'company',
                        'type' => DetailView::INPUT_TEXT,
                    ],
                    [
                        'attribute' => 'position',
                        'type' => DetailView::INPUT_TEXT,
                    ],
                    [
                        'attribute' => 'begin_time',
                        'type' => DetailView::INPUT_DATE,
                        'widgetOptions' => [
                            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
                            'language' => 'zh-CN',
                            'id' => 'pay_date',
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-MM',
                                'todayHighlight' => true,
                                'maxViewMode'=>2,
                                'minViewMode'=>1
                            ]
                        ],
                        'valueColOptions' => ['style' => 'width:60%']
                    ],
                    [
                        'attribute' => 'end_time',
                        'type' => DetailView::INPUT_DATE,
                        'widgetOptions' => [
                            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
                            'language' => 'zh-CN',
                            'id' => 'pay_date',
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-MM',
                                'todayHighlight' => true,
                                'maxViewMode'=>2,
                                'minViewMode'=>1
                            ]
                        ],
                        'valueColOptions' => ['style' => 'width:60%']
                    ],
                ],
                'formOptions' => [
                    'action' => \yii\helpers\Url::toRoute(['adviser-resume/create']),
                ],
            ]); ?>
            <?php Modal::end(); ?>

            <div class="hr"></div>

            <h3 class="title"><?= Yii::t('app', 'Bank card Information') ?></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'bank_card_no',
                    'bank_card_addr',
                    'bank_card_name',
                    'pay_remark',
                ],
                'options' => ['class' => 'table table-hover table-noborder']
            ]) ?>
        </div>
    </div>

    <div class="project-adviser-view">

        <?php
        // $this->render('/project-adviser/_list', [
        //     'dataProvider' => $dataProvider,
        //     'searchModel' => $searchModel,
        // ])
        ?>

    </div>

<?php
$this->registerJs('
        $(document).ready(function(){
            //save
            $(".modal-save").on("click", function(){
                var p_id = '.$model->id.';
                var v = $("#modal2-project-id").val();
                var store = [];
                if(p_id){
                    store.push(p_id);
                }
                if(store.length == 0 || !v){
                    return false;
                }
                $.ajax({
                    url: "/adviser/add-adviser-project",
                    dataType: "json",
                    method: "GET",
                    data: {
                        "adviser_list": store,
                        "project_id": v
                    }
                }).done(function(data){
                    if(data.status == 0) {
                        if(window.localStorage){
                            localStorage.setItem("box_list", "");
                        }
                        $("#add-advisers").modal("hide");
                    }else {
                        $(".modal_tip").text(data.message);
                    }

                });
            });
        })
    ')
?>