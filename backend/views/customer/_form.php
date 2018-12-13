<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\CustomerBoffin;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form cu">
    <?= DetailView::widget([
        'options' => [
            'class' => 'form-inline form',
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
            'name',
            'name_en',
            'short_name',
            'address',
            'describe',
            'website',
            [
                'attribute' => 'tax_type',
                'format' => 'raw',
                'value' => $model->tax_type > 0 ? $model->taxType($model->tax_type) : null,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => $model->taxType(),
                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                ],
            ],

            [
                'columns' => [
                    [
                        'attribute' => 'fee_phone',
                        'labelColOptions' => ['style' => "width: 20%;text-align: right;vertical-align: middle;"],
                    ],
                    [
                        'attribute' => 'fee_phone_type',
                        'value' => $model->fee_phone_type > 0 ? $model->unitType($model->fee_phone_type) : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'labelColOptions' => ['hidden' => true],
                        'widgetOptions' => [
                            'data' => $model->unitType(),
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                            'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        ],
                        'valueColOptions' => ['style' => 'width:35%'],

                    ]
                ],
                'visible' => Yii::$app->user->identity->username == 'admin' ? 1 : 0

            ],
            [
                'columns' => [
                    [
                        'attribute' => 'fee_face',
                        'labelColOptions' => ['style' => "width: 20%;text-align: right;"],

                    ],
                    [
                        'label' => false,
                        'attribute' => 'fee_face_type',
                        'value' => $model->fee_face_type > 0 ? $model->unitType($model->fee_face_type) : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'labelColOptions' => ['hidden' => true],
                        'widgetOptions' => [
                            'data' => $model->unitType(),
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                            'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        ],
                        'valueColOptions' => ['style' => 'width:35%'],

                    ]
                ],
                'visible' => Yii::$app->user->identity->username == 'admin' ? 1 : 0

            ],
            [
                'columns' => [
                    [
                        'attribute' => 'fee_road',
                        'labelColOptions' => ['style' => "width: 20%;text-align: right;"],
                    ],
                    [
                        'attribute' => 'fee_road_type',
                        'value' => $model->fee_road_type > 0 ? $model->unitType($model->fee_road_type) : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'labelColOptions' => ['hidden' => true],
                        'widgetOptions' => [
                            'data' => $model->unitType(),
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                            'options' => ['placeholder' => '-- ' . Yii::t('app', 'Please select')],
                        ],
                        'valueColOptions' => ['style' => 'width:35%'],
                    ]
                ],
                'visible' => Yii::$app->user->identity->username == 'admin' ? 1 : 0
            ],
            'remark',
        ],
        'buttons1' => '{update}',
    ]); ?>

    <?php if (!$model->id) {
        echo Html::tag('p', '请先保存客户信息，再添加研究员信息', ['class' => 'note bg-danger']);
    } ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'customer_id',
            'name_zh',
            'name_en',
            'position',
            'email:email',
            'mobile_phone',
            'tele_phone',
            'wechat',
            'linkedin',

            [
                'contentOptions' => ['style' => 'overflow:hidden;text-overflow:ellipsis;white-space:inherit'],
                'headerOptions' => ['width' => '2%'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'class' => 'updateAdviser',
                            'id' => 'update_project_adviser',
                            'data-toggle' => 'modal',
                            'data-target' => '#update-advisers1',
                            'data-id' => $model->id,
                          
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
                        $url = Url::toRoute(['customer-boffin/delete', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-confirm' => 'Are you sure you want to delete this item?', 'title' => 'Delete', 'data-method' => 'post']);
                    },
                ],
            ],
        ],
    ]); ?>


    <?php Modal::begin([
        'header' => '<h4 class="modal-title">' . Yii::t('app', 'Add Participants') . '</h4>',
        'toggleButton' => ['label' => '<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Participants'), 'class' => 'btn btn-primary', 'disabled' => $model->id ? false : true],
        'options' => ['tabindex' => false]
    ]); ?>

    <?php $boffin = new CustomerBoffin();
    $boffin->customer_id = $model->id;
    ?>
    <?= DetailView::widget([
        'model' => $boffin,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_EDIT,
        'panel' => [
            'heading' => '',
            'type' => DetailView::TYPE_PRIMARY,
        ],
        'attributes' => [
            [
                'attribute' => 'customer_id',
                'type' => DetailView::INPUT_HIDDEN,
            ],
            'name_zh',
            'name_en',
            'position',
            'email',
            'mobile_phone',
            'tele_phone',
            'wechat',
            'linkedin',
        ],
        'formOptions' => [
            'action' => Url::toRoute(['customer-boffin/create', 'id' => $model->id]),
        ],
    ]); ?>

    <?php Modal::end(); ?>

</div>
