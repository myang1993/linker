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
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name_zh',
                    'name_en',
                    [
                        'label' => '地址',
                        'value' => ($model->province ? Area::findOne($model->province)->name . ' ' : ' ') . ($model->city ? Area::findOne($model->city)->name . ' ' : ' ') . ($model->district ? Area::findOne($model->district)->name : ' '),
                    ],
                    [
                        'label' => '行业',
                        'value' => ($model->trade ? Trade::findOne($model->trade)->name . ' ' : ' ') . ($model->child_trade ? Trade::findOne($model->child_trade)->name . ' ' : ' '),
                    ],
                    [
                        'attribute' => 'source_type',
                        'value' => $model->source_type == 0 ? '' : $model->SourceType($model->source_type),
                    ],
                    [
                        'attribute' => 'referee',
                        'value' => $model->getInfo(intval($model->referee)),
                        'visible' => $model->source_type == 3
                    ],
                    [
                        'attribute' => 'referee_fee',
                        'visible' => $model->source_type == 3
                    ],
                    'mobile_phone',
                    'tele_phone',
                    'email',
                    'wechat',
                    'linkedin',
                    'remark',
                    [
                        'attribute' => 'tax_type',
                        'value' => $model->tax_type == 0 ? '' : $model->taxType($model->tax_type),
                    ],
                    [
                        'attribute' => 'fee_phone',
                        'value' => $model->fee_phone . "（" . ($model->fee_phone_type == 0 ? '' : $model->priceType($model->fee_phone_type)) . "）",
                    ],
                    [
                        'attribute' => 'fee_road',
                        'value' => $model->fee_road . "（" . ($model->fee_road_type == 0 ? '' : $model->priceType($model->fee_road_type)) . "）",
                    ],
                    [
                        'attribute' => 'fee_face',
                        'value' => $model->fee_face . "（" . ($model->fee_face_type == 0 ? '' : $model->priceType($model->fee_face_type)) . "）",
                    ],
                    'operator'
                ],
                'options' => ['class' => 'table table-hover table-noborder']
            ]) ?>

            <div class="hr"></div>

            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
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
                    'profile',
                ],
                'options' => ['class' => 'table table-hover table-noborder']
            ]) ?>

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