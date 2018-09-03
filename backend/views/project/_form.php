<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\editable\Editable;
use kartik\select2\Select2;
use kartik\detail\DetailView;
use kartik\depdrop\DepDrop;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use backend\models\ProjectBoffin;
use backend\models\ProjectAdviser;
use backend\models\CustomerBoffin;
use backend\models\Customer;
use backend\models\Adviser;

/* @var $this yii\web\View */
/* @var $model backend\models\Project */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$admin = new \backend\models\Admin();
$model->start_time = ($model->start_time > 0) ? date("Y-m-d H:i", $model->start_time) : date('Y-m-d H:i');
$model->create_time = ($model->create_time > 0) ? date("Y-m-d H:i", $model->create_time) : date('Y-m-d H:i');
$model->date = ($model->date > 0) ? date("Y-m-d H:i", $model->date) : date('Y-m-d H:i');

$customerBoffin = new CustomerBoffin();
$adviser = new Adviser();
$customer = new Customer();
?>

<div class="project-form cu">

    <?= DetailView::widget([
        'options' => [
            'class' => 'form-inline form',
            'id' => 'project_info'
        ],
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'panel' => [
            'heading' => Yii::t('app', 'Customers') . '：' . $model->name,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [
                'attribute' => 'name',
                'valueColOptions' => [
                    'maxlength' => true,
                ],
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => $model->type > 0 ? $model->projectType($model->type) : null,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => $model->projectType(),
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'head',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => $admin->getAdminList(),
                    'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '100%',
                    ],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'participants',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => $admin->getAdminList(),
                    'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '100%',
                        'tags' => false,
                        'multiple' => true,
                    ],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'customer_id',
                'value' => $model->customer ? $model->customer->name : null,
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => $customer->getCustomers(),
                    'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'status',
                'value' => $model->status ? $model->statusType($model->status) : null,
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => $model->statusType(),
                    'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'unit_price',
                        'format' => 'raw',
                        'type' => DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'customer-price'],
                        'labelColOptions' => ['style' => "width: 25%;text-align: right;"],
                        'widgetOptions' => [
                            'data' => [],
                            'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],
                        'valueColOptions' => ['style' => 'width:35%']
                    ],
                    [
                        'attribute' => 'unit_type',
                        'value' => $model->unit_type ? $model->unitType($model->unit_type) : '',
                        'options' => ['id' => 'customer-unit_type'],
                        'labelColOptions' => ['hidden' => true],
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $model->unitType(0),
                            'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select'), 'disabled' => true],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],
                        'valueColOptions' => ['style' => 'width:35%']
                    ],
                    [
                        'label' => Yii::t('app', 'Tax Type'),
                        'format' => 'raw',
                        'labelColOptions' => ['hidden' => true],
                        'value' => ''
                    ]
                ]
            ],
            [
                'attribute' => 'start_time',
                'type' => DetailView::INPUT_DATETIME,
                'widgetOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'convertFormat' => true,
                    'language' => 'zh-CN',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd HH:mm',
                        'todayHighlight' => true,
                    ]
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'create_time',
                'type' => DetailView::INPUT_DATETIME,
                'widgetOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'language' => 'zh-CN',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd HH:mm',
                        'todayHighlight' => true,
                    ]
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            'second',
            'fee_time',
        ],
    ]); ?>
    <?php if (!$model->id) {
        echo Html::tag('p', '请先保存项目信息，再添加研究员和顾问信息', ['class' => 'note bg-danger']);
    } ?>
    <div class="hr"></div>
    <h3 class="title">研究员</h3>
    <?php foreach ($model->projectBoffins as $index => $boffin) {
        echo DetailView::widget([
            'options' => [
                'class' => 'form-inline form',
            ],
            'model' => $boffin,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_VIEW,
            'panel' => [
                'heading' => Yii::t('app', 'projectBoffins') . '：' . $boffin->boffin->name_zh,
                'type' => DetailView::TYPE_INFO,
            ],
            'attributes' => [
                [
                    'attribute' => 'boffin_id',
                    'type' => DetailView::INPUT_HIDDEN,
                ],
                [
                    'label' => Yii::t('app', 'customerBoffins'),
                    'attribute' => 'boffin_id',
                    'value' => $boffin->boffin->name_zh,
                    'format' => 'raw',
                    'options' => ['id' => 'boffin-id' . $index],
                    'type' => DetailView::INPUT_SELECT2,
                    'widgetOptions' => [
                        'data' => $customerBoffin->getCustomerBoffins($model->customer_id),
                        'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        'pluginEvents' => [
                            'change' => 'function() {
                                var boffin_id = $("#projectboffin-boffin_id");
                                var parent = $(this).parents("tr").siblings();
                                var boffin_name_en  = parent.eq(1).find(".kv-form-attribute");
                                var boffin_position = parent.eq(2).find(".kv-form-attribute");
                                var boffin_email    = parent.eq(3).find(".kv-form-attribute");
                                var boffin_mobile   = parent.eq(4).find(".kv-form-attribute");
                                var boffin_tele     = parent.eq(5).find(".kv-form-attribute");
                                var boffin_wechat   = parent.eq(6).find(".kv-form-attribute");
                                var boffin_link     = parent.eq(7).find(".kv-form-attribute");
                                var val = $(this).val();
                                if(val){
                                    boffin_id.val(val);
                                    $.ajax({
                                        url: "/customer-boffin/info",
                                        dataType: "json",
                                        method: "GET",
                                        data: "id="+val,
                                        success: function(data){
                                            boffin_name_en.text(data.name_en);
                                            boffin_position.text(data.position);
                                            boffin_email.text(data.email);
                                            boffin_mobile.text(data.mobile_phone);
                                            boffin_tele.text(data.tele_phone);
                                            boffin_wechat.text(data.wechat);
                                            boffin_link.text(data.linkedin);
                                        }
                                    });
                                }
                            }',
                        ],
                    ],
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                [
                    'label' => Yii::t('app', 'English Name'),
                    'value' => $boffin->boffin->name_en,
                    'displayOnly' => true,
                ],
                [
                    'label' => Yii::t('app', 'Position'),
                    'value' => $boffin->boffin->position,
                    'displayOnly' => true,
                ],
                [
                    'label' => Yii::t('app', 'E-mail'),
                    'value' => $boffin->boffin->email,
                    'displayOnly' => true,
                ],
                [
                    'label' => Yii::t('app', 'Mobile Phone'),
                    'value' => $boffin->boffin->mobile_phone,
                    'displayOnly' => true,
                ],
                [
                    'label' => Yii::t('app', 'Tele Phone'),
                    'value' => $boffin->boffin->tele_phone,
                    'displayOnly' => true,
                ],
                [
                    'label' => Yii::t('app', 'Wechat'),
                    'value' => $boffin->boffin->wechat,
                    'displayOnly' => true,
                ],
                [
                    'label' => Yii::t('app', 'Linkedin'),
                    'value' => $boffin->boffin->linkedin,
                    'displayOnly' => true,
                ],
            ],
            'deleteOptions' => [
                'params' => ['id' => $boffin->id, 'delete' => true],
                'url' => Url::toRoute(['project-boffin/delete', 'id' => $model->id]),
            ],
            'formOptions' => [
                'action' => Url::toRoute(['project-boffin/update', 'id' => $model->id]),
            ],
        ]);
    } ?>

    <?php
    $projectBoffin = new ProjectBoffin();
    $projectBoffin->project_id = $model->id;
    ?>

    <?php Modal::begin([
        'header' => '<h4 class="modal-title">' . Yii::t('app', 'Add Participants') . '</h4>',
        'toggleButton' => ['label' => '<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Participants'), 'class' => 'btn btn-primary', 'disabled' => $projectBoffin->project_id ? false : true],
        'options' => ['tabindex' => false]
    ]); ?>

    <?= DetailView::widget([
        'model' => $projectBoffin,
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
                'attribute' => 'project_id',
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'label' => Yii::t('app', 'customerBoffins'),
                'attribute' => 'boffin_id',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'options' => ['id' => 'modal1-boffin-id', 'placeholder' => 'Please select'],
                'widgetOptions' => [
                    'data' => $customerBoffin->getCustomerBoffins($model->customer_id),
                    'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'label' => Yii::t('app', 'English Name'),
                'value' => '',
                'options' => ['id' => 'modal1-boffin-name_en'],
                'displayOnly' => true,
            ],
            [
                'label' => Yii::t('app', 'Position'),
                'options' => ['id' => 'modal1-boffin-position'],
                'value' => '',
                'displayOnly' => true,
            ],
            [
                'label' => Yii::t('app', 'E-mail'),
                'options' => ['id' => 'modal1-boffin-email'],
                'value' => '',
                'displayOnly' => true,
            ],
            [
                'label' => Yii::t('app', 'Mobile Phone'),
                'options' => ['id' => 'modal1-boffin-mobile'],
                'value' => '',
                'displayOnly' => true,
            ],
            [
                'label' => Yii::t('app', 'Tele Phone'),
                'options' => ['id' => 'modal1-boffin-tele'],
                'value' => '',
                'displayOnly' => true,
            ],
            [
                'label' => Yii::t('app', 'Wechat'),
                'value' => '',
                'options' => ['id' => 'modal1-boffin-wechat'],
                'displayOnly' => true,
            ],
            [
                'label' => Yii::t('app', 'Linkedin'),
                'options' => ['id' => 'modal1-boffin-link'],
                'value' => '',
                'displayOnly' => true,
            ],
        ],
        'formOptions' => [
            'action' => Url::toRoute(['project-boffin/create', 'id' => $model->id]),
        ],
    ]); ?>

    <?php Modal::end(); ?>

    <div class="hr"></div>
    <h3 class="title">顾问
        <?php
        echo Html::a('<i class="glyphicon glyphicon-envelope"></i>' . Yii::t('app', 'Create Email'), '#', [
            'class' => 'btn btn-success create-email',
            'id' => 'Create-Email',
            'data-toggle' => 'modal',
            'data-target' => '#create-email',
            'style' => 'float:right',
        ]);
        ?>
    </h3>
    <?php
    if (Yii::$app->controller->action->id == 'update') {
        echo \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['style' => 'table-layout: fixed;word-wrap: break-word;word-break:break-all', 'class' => 'table table-striped table-bordered'],
            'columns' => [
                [
                    'label' => Yii::t('app', 'ID'),
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width:2%;'],
                ],
                [
                    'label' => Yii::t('app', 'Chinese Name'),
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->adviser->name_zh, "/adviser/view?id=".$data->id);;

                    },
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '5%'],
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '5%'],
                    'label' => Yii::t('app', 'Company'),
                    'value' => function ($data) {
                        return $data->adviser->company;
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '5%'],
                    'label' => Yii::t('app', 'Position'),
                    'value' => function ($data) {
                        return $data->adviser->position;
                    }
                ],
                [
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '20%'],
                    'label' => Yii::t('app', 'Background'),
                    'value' => function ($data) {
                        return $data->adviser->describe;
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '5%'],
                    'label' => Yii::t('app', '安排人员'),
                    'value' => function ($data) {
                        return $data->admin ? $data->admin->username : $data->admin;
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '6%'],
                    'label' => Yii::t('app', '状态'),
                    'value' => function ($data) {
                        return $data->state == 0 ? '' : $data->stateType($data->state);
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '9%'],
                    'label' => Yii::t('app', '备注'),
                    'value' => 'remark'
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '3%'],
                    'label' => Yii::t('app', '顾问倍率'),
                    'value' => 'fee_rate'
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;white-space:inherit'],
                    'headerOptions' => ['width' => '8%'],
                    'label' => Yii::t('app', '访谈费率'),
                    'value' => function ($data) {
                        $tax_type = empty($data->adviser->tax_type) ? '' : $data->adviser->taxType($data->adviser->tax_type);
                        $pay_type = empty($data->pay_type) ? '' : $data->adviser->payType($data->pay_type);
                        $fee_type = empty($data->fee_type) ? '' : $data->adviser->priceType($data->fee_type);
                        return $tax_type . ' ' . $pay_type . ' ' . $data->fee . '（' . $fee_type . '）';
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '9%'],
                    'label' => Yii::t('app', '访谈日期'),
                    'value' => function ($data) {
                        return date('Y-m-d H:i:s', $data->date);
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '6%'],
                    'label' => Yii::t('app', '支付备注'),
                    'value' => 'pay_remark'
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '6%'],
                    'label' => Yii::t('app', '访谈时长(分钟)'),
                    'value' => function ($model) {
                        return $model->duration;
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '6%'],
                    'label' => Yii::t('app', '访谈时长(小时)'),
                    'value' => function ($model) {
                        return $model->hour;
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '6%'],
                    'label' => Yii::t('app', '专家成本'),
                    'value' => function ($model) {
                        return $model->cost;
                    }
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '2%'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
//                            $url = Url::toRoute(['project-adviser/update', 'id' => $model->id]);
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                                'class' => 'updateAdviser',
                                'id' => 'update_project_adviser',
                                'data-toggle' => 'modal',
                                'data-target' => '#update-advisers1',
                                'data-id' => $model->id,
                                'data-adviser-id' => $model->adviser->id,
                                'data-adviser-fee' => $model->fee,
                                'data-fee-type' => $model->fee_type,
                                'data-pay-type' => $model->pay_type,
                                'style' => 'float:right',]);
                        },
                    ],
                ],
                [
                    'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                    'headerOptions' => ['width' => '2%'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            $url = Url::toRoute(['project-adviser/delete', 'id' => $model->id, 'project_id' => $model->project_id]);
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-confirm' => 'Are you sure you want to delete this item?', 'title' => 'Delete', 'data-method' => 'post']);
                        },
                    ],
                ],
            ],
        ]);
    }
    ?>

    <?php
    $projectAdviser = new ProjectAdviser();
    $projectAdviser->project_id = $model->id;
    $projectAdviser->date = $projectAdviser->date ? date("Y-m-d H:i", $projectAdviser->date) : date('Y-m-d H:i');
    ?>

    <?php
    //编辑顾问信息
    ?>
    <!-- // Url::toRoute(['adviser/info', 'id' => '']) -->
    <?php
    foreach ($model->projectAdvisers as $index => $projectAdviser) {
        Modal::begin([
            'header' => '<h4 class="modal-title">' . Yii::t('app', 'Update Adviser') . '</h4>',
            'id' => 'update-advisers' . ($projectAdviser->id),
            'options' => ['tabindex' => false]
        ]);
        $projectAdviser->date = ($projectAdviser->date > 0) ? date("Y-m-d H:i", $projectAdviser->date) : date('Y-m-d H:i');
//        $select_fee = $projectAdviser->getInfo($projectAdviser->adviser_id);
        echo DetailView::widget([
            'options' => [
                'class' => 'form-inline form',
            ],
            'model' => $projectAdviser,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_EDIT,
            'panel' => [
                'heading' => '<i id="icon_triangle' . $index . '" class="glyphicon glyphicon-triangle-top"></i>' . Yii::t('app', 'projectAdviser') . '：' . $projectAdviser->adviser->name_zh,
                'type' => DetailView::TYPE_INFO,
            ],
            'attributes' => [
                [
                    'attribute' => 'id',
                    'type' => DetailView::INPUT_HIDDEN,
                ],
                [
                    'attribute' => 'adviser_id',
                    'value' => $projectAdviser->adviser->name_zh,
                    'format' => 'raw',
                    'options' => ['id' => 'adviser-id' . $index],
                    'type' => DetailView::INPUT_SELECT2,
                    'displayOnly' => true,
                    'widgetOptions' => [
                        'data' => $adviser->getAdviser(),
                        'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                [
                    'attribute' => 'selector_id',
                    'value' => !is_object($projectAdviser->admin) ? null : $projectAdviser->admin->username,
                    'format' => 'raw',
                    'options' => ['id' => 'selector-id' . $index],
                    'type' => DetailView::INPUT_SELECT2,
                    'widgetOptions' => [
                        'data' => $admin->getAdminIdList(),
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                [
                    'attribute' => 'state',
                    'value' => $projectAdviser->state == 0 ? '' : $projectAdviser->stateType($projectAdviser->state),
                    'format' => 'raw',
                    'options' => ['id' => 'state' . $index],
                    'type' => DetailView::INPUT_SELECT2,
                    'widgetOptions' => [
                        'data' => $projectAdviser->stateType(),
                        'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                [
                    'attribute' => 'remark',
                    'value' => $projectAdviser->adviser->remark,
                ],
                'duration',
                'hour',
                [
                    'attribute' => 'fee_rate',
                    'format' => 'raw',
                    'value' => $projectAdviser->fee_rate,
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                'cost',
                [
                    'attribute' => 'fee',
                    'format' => 'raw',
                    'type' => DetailView::INPUT_SELECT2,
                    'options' => ['id' => 'fee' . $projectAdviser->id, 'placeholder' => '-- ' . Yii::t('app', 'Please select'), 'readonly' => 'readonly'],
                    'widgetOptions' => [
                        'data' => [],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                [
                    'attribute' => 'fee_type',
                    'options' => ['id' => 'fee_type' . $projectAdviser->id],
                    'type' => DetailView::INPUT_HIDDEN,
                ],
                [
                    'attribute' => 'pay_type',
                    'options' => ['id' => 'pay_type' . $projectAdviser->id],
                    'type' => DetailView::INPUT_HIDDEN,
                ],
                [
                    'attribute' => 'date',
                    'type' => DetailView::INPUT_DATETIME,
                    'options' => ['id' => 'date' . $index],
                    'widgetOptions' => [
                        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                        'language' => 'zh-CN',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-MM-dd HH:mm',
                            'todayHighlight' => true,
                        ]
                    ],
                    'valueColOptions' => ['style' => 'width:60%']
                ],
                [
                    'attribute' => 'pay_remark',
                    'value' => $projectAdviser->adviser->pay_remark,
                    'displayOnly' => true,
                ]
            ],
            'deleteOptions' => [
                'params' => ['id' => $projectAdviser->id, 'delete' => true],
                'url' => Url::toRoute(['project-adviser/delete', 'id' => $model->id]),
            ],
            'formOptions' => [
                'action' => Url::toRoute(['project-adviser/update', 'id' => $model->id]),
            ],
        ]);
        Modal::end();
    } ?>

    <?php Modal::begin([
        'header' => '<h4 class="modal-title">' . Yii::t('app', 'Add Adviser') . '</h4>',
        'id' => 'add-advisers',
        'toggleButton' => ['label' => '<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Adviser'), 'class' => 'btn btn-primary', 'disabled' => $projectAdviser->project_id ? false : true],
        'options' => ['tabindex' => false]
    ]); ?>
    <!-- // Url::toRoute(['adviser/info', 'id' => '']) -->
    <?= DetailView::widget([
        'model' => $projectAdviser,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_EDIT,
        'container' => ['id' => 'kv-demo2'],
        'panel' => [
            'heading' => '',
            'type' => DetailView::TYPE_PRIMARY,
        ],
        'attributes' => [
            [
                'attribute' => 'project_id',
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute' => 'adviser_id',
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
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'label' => Yii::t('app', 'Company'),
                'contentOptions' => ['id' => 'modal2-adviser_company', 'readonly' => 'readonly'],
                'value' => '',

            ],
            [
                'label' => Yii::t('app', 'Position'),
                'contentOptions' => ['id' => 'modal2-adviser_position', 'readonly' => 'readonly'],
                'value' => '',
            ],
            [
                'label' => Yii::t('app', 'Background'),
                'contentOptions' => ['id' => 'modal2-adviser_describe', 'readonly' => 'readonly'],
                'value' => '',
            ],
            [
                'attribute' => 'selector_id',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'options' => ['id' => 'modal2-selector-id', 'placeholder' => '-- ' . Yii::t('app', 'Please select')],
                'widgetOptions' => [
                    'data' => $admin->getAdminIdList(),
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'state',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'options' => ['id' => 'modal2-state', 'placeholder' => '-- ' . Yii::t('app', 'Please select')],
                'widgetOptions' => [
                    'data' => $projectAdviser->stateType(),
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'remark',
                'options' => ['id' => 'modal2-remark'],
            ],
            'duration',
            [
                'attribute' => 'fee_rate',
                'format' => 'raw',
                'value' => $projectAdviser->fee_rate,
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'fee',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'options' => ['id' => 'modal2-fee', 'placeholder' => '-- ' . Yii::t('app', 'Please select'), 'readonly' => 'readonly'],
                'widgetOptions' => [
                    'data' => [],
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'fee_type',
                'options' => ['id' => 'modal2-fee_type'],
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute' => 'pay_type',
                'options' => ['id' => 'modal2-pay_type'],
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute' => 'date',
                'type' => DetailView::INPUT_DATETIME,
                'options' => ['id' => 'modal2-date'],
                'widgetOptions' => [
                    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                    'language' => 'zh-CN',
                    'id' => 'pay_date',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd HH:mm',
                        'todayHighlight' => true,
                        'id' => 'pay_date',
                    ]
                ],
                'valueColOptions' => ['style' => 'width:60%']
            ],
            [
                'attribute' => 'pay_remark',
                'options' => ['id' => 'modal2-pay_remark', 'readonly' => 'readonly'],
            ],
        ],
        'formOptions' => [
            'action' => Url::toRoute(['project-adviser/create', 'id' => $model->id]),
        ],
    ]); ?>
    <?php Modal::end(); ?>

    <?php
    if (!empty($model->projectBoffins[0])) {
        Modal::begin([
            'header' => '<h4 class="modal-title">' . Yii::t('app', 'Create Email') . '</h4>',
            'id' => 'create-email',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
        ]);
        echo $model->projectBoffins[0]->boffin->name_zh . '你好：<br>&nbsp;&nbsp;&nbsp;&nbsp;我是Linker的' . Yii::$app->user->identity->username
            . '，下面几位专家您看是否合适，如果有需要约访的，欢迎您随时联系我，谢谢。<br>';

        foreach ($model->projectAdvisers as $index => $projectAdviser) {
            echo '<div class="row" style="padding: 15px 15px 5px;"><div class="col-md-12" style="">ID:' . ($index + 1) . '</div><div class="col-md-12" style="line-height:20px; font-weight: bold;">' . $projectAdviser->adviser->company . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $projectAdviser->adviser->position . '</div><div class="col-md-12"><span style="font-weight:bold;">Experience:&nbsp;&nbsp;</span>' . $projectAdviser->adviser->describe . '</div><div class="col-md-12"><span style="font-weight:bold;">Comments:&nbsp;&nbsp;</span>' . $projectAdviser->remark . '</div><div class="col-md-12" style="height:10px;">&nbsp;&nbsp;</div></div>';
        }

        Modal::end();
    }

    ?>

</div>
<?php
$this->registerJs(
    '$(document).ready(function(){
            //设置参与者的值
            var arr = "' . $model->participants . '";
            arr = arr.split("，");
            console.log(arr);
            $("#project-participants").val(arr).trigger("change");

            var ctm_p = $("#customer-price");
            var ctm_id = $("#project-customer_id");
            var ctm_t = $("#customer-unit_type");
            var cell = $("tr.kv-child-table-row").find(".kv-attribute");
            function init_ajax(v){
                $.ajax({
                    url: "/customer/info",
                    dataType: "json",
                    method: "GET",
                    data: "id="+v,
                    success: function(data){
                        console.log(data);
                        data = data;
                        var tmp = [];
                        tmp[0] = "<option value="+data.fee_face+" data-type="+data.fee_face_type+" data-pay=fee_face>' . Yii::t('app', 'Face Interview Price') . ' </option>";
                        tmp[1] = "<option value="+data.fee_phone+" data-type="+data.fee_phone_type+" data-pay=fee_phone>' . Yii::t('app', 'Telephone Interview Price') . '</option>";
                        tmp[2] = "<option value="+data.fee_road+" data-type="+data.fee_road_type+" data-pay=fee_road>' . Yii::t('app', 'Roadshow Interview Price') . '</option>";

                        for(var i=0;i<3;i++){
                            ctm_p.append(tmp[i]);
                        }

                        ctm_t.val(data.fee_face_type);
                        if(cell.length == 3){
                            if($(cell[1]).next().attr("class") == "kv-form-attribute"){
                                $(cell[1]).next().addClass("hide");
                            }
                            $(cell[2]).text(data.tax_type_v);
                        }

                    }
                });
            }
            var tmp = ctm_id.val();
            init_ajax(tmp);

            //客户信息
            ctm_id.on("change", function(){
                ctm_p.empty();
                var ctm_v = $(this).val();
                if(ctm_v){
                    init_ajax(ctm_v);
                }
            });

            ctm_p.on("change", function(){
                var vt = $(this).find("option:selected").attr("data-type");
                console.log(tmp, ctm_t.val());
                ctm_t.val(vt);
                console.log(ctm_t, ctm_t.val());
            });

            //添加顾问弹框
            var sel2 = $("#modal2-fee");
            var fee_type = $("#modal2-fee_type");
            var pay_type = $("#modal2-pay_type");
            var form_stretch = $("#form-stretch");
            var tmp = $("#kv-demo2").find("table tbody").children();
            var adv_cmp = tmp.eq(2).find(".kv-form-attribute");
            var adv_pos = tmp.eq(3).find(".kv-form-attribute");
            var adv_des = tmp.eq(4).find(".kv-form-attribute");
            $("#modal2-adviser-id").on("change", function() {
                sel2.empty();
                var val = $(this).val();
                console.log(val);
                if(val){
                    $.ajax({
                        url: "/adviser/info",
                        dataType: "json",
                        method: "GET",
                        data: {id:val},
                        success: function(data){
                            data = data;
                            $("#modal2-remark").val(data.remark);
                            $("#modal2-pay_remark").val(data.pay_remark);
                            var tmp = [];
                            tmp[0] = "<option value="+data.fee_face+" data-type="+data.fee_face_type+" data-pay=fee_face>("+data.tax_type_v+") ' . Yii::t('app', 'Face Interview Price') . ' "+data.fee_face+" ("+data.fee_face_type_v+")</option>";
                            tmp[1] = "<option value="+data.fee_phone+" data-type="+data.fee_phone_type+" data-pay=fee_phone>("+data.tax_type_v+") ' . Yii::t('app', 'Telephone Interview Price') . ' "+data.fee_phone+" ("+data.fee_phone_type_v+")</option>";
                            tmp[2] = "<option value="+data.fee_road+" data-type="+data.fee_road_type+" data-pay=fee_road>("+data.tax_type_v+") ' . Yii::t('app', 'Roadshow Interview Price') . ' "+data.fee_road+" ("+data.fee_road_type_v+")</option>";

                            for(var i=0;i<3;i++){
                                sel2.append(tmp[i]);
                            }

                            fee_type.val(data.fee_face_type);
                            pay_type.val("fee_face");
                            adv_cmp.text(data.company);
                            adv_pos.text(data.position);
                            adv_des.text(data.describe);
                        }
                    });
                }
            });

            sel2.on("change", function(){
                var tmp = sel2.find("option:selected");
                fee_type.val(tmp.attr("data-type"));
                pay_type.val(tmp.attr("data-pay"));
            });

            form_stretch.on("click", function(e){
                console.log(e.target.id);
                if(e.target.id.indexOf("icon_triangle") > -1){
                    var target = $("#"+e.target.id);
                    var parent = target.parent().parent().parent();
                    console.log(target.attr("class").indexOf("glyphicon-triangle-top"));
                    if(target.attr("class").indexOf("glyphicon-triangle-top") > 0){
                        target.addClass("glyphicon-triangle-bottom");
                        target.removeClass("glyphicon-triangle-top");
                        parent.find(".table-responsive").addClass("stretch");
                    }else {
                        target.removeClass("glyphicon-triangle-bottom");
                        target.addClass("glyphicon-triangle-top");
                        parent.find(".table-responsive").removeClass("stretch");
                    }
                }


            });
            
            //添加研究院弹框
            var kv_demo = $("#kv-demo");
            var boffin_id = $("#modal1-boffin-id");
            var tmp2 = kv_demo.find("table tbody").children();

            var boffin_name_en  = tmp2.eq(2).find(".kv-form-attribute");
            var boffin_position = tmp2.eq(3).find(".kv-form-attribute");
            var boffin_email    = tmp2.eq(4).find(".kv-form-attribute");
            var boffin_mobile   = tmp2.eq(5).find(".kv-form-attribute");
            var boffin_tele     = tmp2.eq(6).find(".kv-form-attribute");
            var boffin_wechat   = tmp2.eq(7).find(".kv-form-attribute");
            var boffin_link     = tmp2.eq(8).find(".kv-form-attribute");
            boffin_id.on("change", function(){
                var v = $(this).val();
                if(v){
                    $.ajax({
                        url: "/customer-boffin/info",
                        dataType: "json",
                        method: "GET",
                        data: "id="+v,
                        success: function(data){
                            boffin_name_en.text(data.name_en);
                            boffin_position.text(data.position);
                            boffin_email.text(data.email);
                            boffin_mobile.text(data.mobile_phone);
                            boffin_tele.text(data.tele_phone);
                            boffin_wechat.text(data.wechat);
                            boffin_link.text(data.linkedin);
                        }
                    });
                }
            });
        })'
);
?>

<?php

$js = <<<JS
$('.updateAdviser').click(function(){
    var index = $(this).parent().parent().find('td').eq(0).text();
    $(this).attr('data-target','#update-advisers'+index);
    var adviser_id = $(this).attr('data-adviser-id');
    var adviser_fee = $(this).attr('data-adviser-fee');
    var data_fee_type = $(this).attr('data-fee-type');
    var data_pay_type = $(this).attr('data-pay-type');
    var sel2 = $("#fee"+index);
    var fee_type = $("#fee_type"+index);
    var pay_type = $("#pay_type"+index);
      $.ajax({
        url: "/adviser/info",
        dataType: "json",
        method: "GET",
        data: {id:adviser_id},
        success: function(data){
            sel2.empty();
            data = data;
            var tmp = [];
            if (adviser_fee ==data.fee_face && data_fee_type == data.fee_face_type && data_pay_type == 'fee_face') {
               tmp[0] = "<option value="+data.fee_face+" data-type="+data.fee_face_type+" data-pay=fee_face selected>("+data.tax_type_v+") 面谈访谈费率"+data.fee_face+" ("+data.fee_face_type_v+")</option>"; 
            } else {
                tmp[0] = "<option value="+data.fee_face+" data-type="+data.fee_face_type+" data-pay=fee_face>("+data.tax_type_v+") 面谈访谈费率"+data.fee_face+" ("+data.fee_face_type_v+")</option>";
            }
             if (adviser_fee ==data.fee_phone && data_fee_type == data.fee_phone_type && data_pay_type == 'fee_phone') {
                 tmp[1] = "<option value="+data.fee_phone+" data-type="+data.fee_phone_type+" data-pay=fee_phone selected>("+data.tax_type_v+") 电话访谈费率 "+data.fee_phone+" ("+data.fee_phone_type_v+")</option>";
             } else {
                 tmp[1] = "<option value="+data.fee_phone+" data-type="+data.fee_phone_type+" data-pay=fee_phone>("+data.tax_type_v+") 电话访谈费率 "+data.fee_phone+" ("+data.fee_phone_type_v+")</option>";
             }
             if (adviser_fee ==data.fee_road && data_fee_type == data.fee_road_type && data_pay_type == 'fee_road') {
                 tmp[2] = "<option value="+data.fee_road+" data-type="+data.fee_road_type+" data-pay=fee_road selected>("+data.tax_type_v+") 路演访谈费率 "+data.fee_road+" ("+data.fee_road_type_v+")</option>";
             } else {
                 tmp[2] = "<option value="+data.fee_road+" data-type="+data.fee_road_type+" data-pay=fee_road>("+data.tax_type_v+") 路演访谈费率 "+data.fee_road+" ("+data.fee_road_type_v+")</option>";
             }
    
            for(var i=0;i<3;i++){
                sel2.append(tmp[i]);
            }
        }
    });
      
      sel2.on("change", function(){
                var tmp = sel2.find("option:selected");
                fee_type.val(tmp.attr("data-type"));
                pay_type.val(tmp.attr("data-pay"));
            });

});

JS;
$this->registerJs($js);
?>
