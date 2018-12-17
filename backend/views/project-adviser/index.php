<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use backend\models\Admin;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectAdviserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', '财务');
$this->params['breadcrumbs'][] = Yii::t('app', '财务');
?>
<div class="project-adviser-index list">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    echo GridView::widget([
        'id' => 'finance-list',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'kartik\grid\SerialColumn'],
            'id',
            [
                'label' => Yii::t('app', '日期'),
                'attribute' => 'project_date',
                'value' => function ($data) {
                    return date('Y-m-d H:i', $data->date);
                },
            ],
            [
                'label' => Yii::t('app', '客户名称'),
                'attribute' => 'customer',
                'value' => 'project.customer.name',
            ],
            [
                'label' => Yii::t('app', '客户访问者'),
                'attribute' => 'boffin',
                'value' => function ($model) {
                    $boffins = '';
                    foreach ($model->project->projectBoffins as $boffin) {
                        $boffins .= '，' . $boffin->boffin->name_zh;
                    }
                    return ltrim($boffins, '，');
                },
            ],
            [
                'label' => Yii::t('app', '项目名称'),
                'attribute' => 'project_name',
                'value' => 'project.name',
            ],
            [
                'label' => Yii::t('app', '项目编号'),
                'attribute' => 'project_id',
                'value' => 'project.id',
                'vAlign' => 'middle',
            ],
            [
                'label' => Yii::t('app', '实际访谈小时数'),
                'attribute' => 'hour',
            ],
            [
                'label' => Yii::t('app', '高级专家倍数'),
                'attribute' => 'fee_rate',
            ],
            [
                'label' => Yii::t('app', '收费访谈小时数'),
                'attribute' => 'cost_time',
                'value' => function ($model) {
                    return $model->hour * $model->fee_rate;
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'label' => Yii::t('app', '收客户费用'),
                'attribute' => 'customer_fee',
                'value' => 'customer_fee',
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'asPopover' => false,
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    ];
                }
            ],
            [
                'label' => Yii::t('app', '专家姓名'),
                'attribute' => 'adviser_name',
                'value' => function ($model) {
                    return $model->adviser->name_zh;
                },
            ],
            [
                'label' => Yii::t('app', '专家职位'),
                'attribute' => 'adviser_position',
                'value' => function ($model) {
                    return $model->adviser->position;
                },
            ],
            [
                'label' => Yii::t('app', '专家公司'),
                'attribute' => 'adviser_company',
                'value' => function ($model) {
                    return $model->adviser->company;
                },
            ],
            [
                'label' => Yii::t('app', '客户单价'),
                'attribute' => 'unit_price',
                'value' => function ($model) {
                    $tmp = empty($model->project->unit_type) || $model->project->unit_type == 0 ? 1: $model->project->unit_type;
                    return $model->project->unit_price . '（' . $model->project->unitType($tmp) . '）';
                },
            ],
            [
                'label' => Yii::t('app', '是否含税价'),
                'attribute' => 'contain_tax',
                'value' => function ($model) {
                    return $model->adviser->taxType($model->adviser->tax_type);
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'label' => Yii::t('app', '是否已出账单'),
                'attribute' => 'bill_out',
                'value' => function ($model) {
                    return $model->bill_out == 1 ? '否' : '是';
                },
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'asPopover' => false,
                        'data' => [1 => '否', 2 => '是'],
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    ];
                }
            ],
            [
                'label' => Yii::t('app', '项目类型'),
                'attribute' => 'project_type',
                'value' => function ($model) {
                    return $model->project->projectType($model->project->type);
                },
            ],
            [
                'label' => Yii::t('app', '项目经理'),
                'attribute' => 'project_manager',
                'value' => function ($model) {
                    return Admin::findById($model->selector_id) ? Admin::findById($model->selector_id)->username : '';
                },
            ],
            [
                'label' => Yii::t('app', '备注'),
                'attribute' => 'remark',
            ],
            [
                'label' => Yii::t('app', '专家费率'),
                'attribute' => 'adviser_fee',
                'value' => function ($model) {
                    $tmp = $model->adviser->tax_type == 0 ? 1 : $model->adviser->tax_type;
                    $tmp2 = empty($model->fee_type) ? 1 : $model->fee_type;
                    return $model->adviser->taxType($tmp) . ' ' . $model->fee . ' ' . $model->adviser->priceType($tmp2);
                },
            ],
            [
                'label' => Yii::t('app', '专家分钟数'),
                'attribute' => 'duration',
            ],
            [
                'label' => Yii::t('app', '收款户名'),
                'attribute' => 'adviser_bank_name',
                'value' => function ($model) {
                    return $model->adviser->bank_card_name;
                },
            ],
            [
                'label' => Yii::t('app', '专家银行账号'),
                'attribute' => 'adviser_bank_card',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->addSpace($model->adviser->bank_card_no);
                },
            ],
            [
                'label' => Yii::t('app', '专家银行（精确到支行）'),
                'attribute' => 'adviser_bank_addr',
                'value' => function ($model) {
                    return $model->adviser->bank_card_addr;
                },
            ],
            [
                'label' => Yii::t('app', '专家成本'),
                'value' => function ($model) {
                    return $model->cost;
                },
            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'adviser_pay',
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return $model->adviser_pay == 1 ? '否' : '是';
                },
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'asPopover' => false,
                        'data' => [1 => '否', 2 => '是'],
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    ];
                }
            ],
            [
                'label' => Yii::t('app', '是否有推荐人'),
                'attribute' => 'referee',
                'value' => function ($model) {
                    return $model->adviser->referee > 0 ? Yii::t('app', '有') : Yii::t('app', '无');
                },
            ],
            [
                'label' => Yii::t('app', '推荐费'),
                'attribute' => 'referee_fee',
                'value' => function ($model) {
                    return $model->adviser->referee > 0 ? $model->adviser->referee_fee : '';
                },
            ],
            [
                'label' => Yii::t('app', '推荐人户名'),
                'attribute' => 'referee_bank_name',
                'value' => function ($model) {
                    return $model->adviser->referee > 0 ? $model->adviser->referee0->bank_card_name : '';
                },
            ],
            [
                'label' => Yii::t('app', '推荐人银行账号'),
                'attribute' => 'referee_bank_card',
                'value' => function ($model) {
                    return $model->adviser->referee > 0 ? $model->adviser->referee0->bank_card_no : '';
                },
            ],
            [
                'label' => Yii::t('app', '推荐人银行（精确到支行）'),
                'attribute' => 'referee_bank_addr',
                'value' => function ($model) {
                    return $model->adviser->referee > 0 ? $model->adviser->referee0->bank_card_addr : '';
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'referee_pay',
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return $model->adviser_pay == 1 ? '否' : '是';
                },
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'name' => 'referee_pay',
                        'size' => 'md',
                        'formOptions' => [
                            'action' => ['prject-adviser/update', 'id' => $model->id]
                        ],
                        'asPopover' => false,
                        'data' => [1 => '否', 2 => '是'],
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'options' => ['class' => 'form-control', 'placeholder' => 'Enter person name...'],
                    ];
                }

            ]
        ],
        'containerOptions' => ['style' => 'overflow: auto'],
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'toolbar' => [
            ['content' =>
               '<form id="import_xls" class="form-inline" action="/project-adviser/import" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputName2">导入文件：</label>
                    <input type="file" name="file" id="file" style="display:inline-block" accept="application/vnd.ms-excel"><br>
                </div></form>'
            ],
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', '刷新')])],
            '{export}',
            '{toggleData}'
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'filename' => 'project_list',
                'config' => [
                    'mode'=>'GB2312',
                ]
            ],
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => false,
        'showPageSummary' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
    ]);
    ?>

    <?php
    // echo $this->render('_list', [
    //     'dataProvider' => $dataProvider,
    //     'searchModel' => $searchModel,
    // ]);
    ?>
</div>

<?php

$js = <<<JS
$('#file').change(function(){
    $("#import_xls").submit();
});

JS;
$this->registerJs($js);
?>
