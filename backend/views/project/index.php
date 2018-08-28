<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index list">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => [
                    'style' => 'width: 80px;'
                ]
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->name, "/project/update?id=".$data->id);
                },
            ],
            [
                'label' => Yii::t('app', '客户'),
                'attribute' => 'customer_name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->customer->name, "/customer/update?id=".$data->customer_id);
                },
            ],
            [
                'attribute' => 'head',
                'contentOptions' => [
                    'style' => 'width: 120px;'
                ]
            ],
            'participants',
            [
                'attribute' => 'status',
                'filter' => $searchModel->statusType(0),
                'value' => function($data){
                    return $data->statusType($data->status);
                },
                'contentOptions' => [
                    'style' => 'width: 120px;'
                ]
            ],
            [
                'attribute' => 'start_time',
                'value' => function($data){
                    return date('Y-m-d', $data->start_time);
                },
            ],
            [
                'attribute' => 'create_time',
                'value' => function($data){
                    return date('Y-m-d', $data->create_time);
                },
            ],
            [
                'label' => Yii::t('app', '参与顾问'),
                'attribute'=> 'adviser_name',
                'value' => function ($model) {
                    $selector = array();
                    foreach ($model->advisers as $adviser) {
                        if (!$adviser->name_zh) {
                            continue;
                        }
                        $selector[] = $adviser->name_zh;
                    }
                    $unique = array_unique($selector);
                    return implode('，', $unique);
                }
            ],
            [
                'label' => Yii::t('app', '参与研究员'),
                'attribute' => 'boffin_name',
                'value' => function ($model) {
                    $selector = array();
                    foreach ($model->boffins as $boffin) {
                        if (!$boffin->name_zh) {
                            continue;
                        }
                        $selector[] = $boffin->name_zh;
                    }
                    $unique = array_unique($selector);
                    return implode('，', $unique);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
