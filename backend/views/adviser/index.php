<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Area;
use backend\models\Trade;
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
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['id' => 'adviser_list'],
        'columns' => [
            [
                'attribute' => 'name_zh',
                'contentOptions' => [
                    'style' => 'min-width: 60px;'
                ]
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
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{delete}',
//            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>