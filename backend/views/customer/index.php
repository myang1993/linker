<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index list">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Customer'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'value'=> function($data){
                    //超链接
                    return Html::a($data->id, "/customer/update?id=".$data->id);
                }
            ],
            [
                'attribute'=>'name',
                'value'=> function($data){
                    //超链接
                    return Html::a($data->name, "/customer/update?id=".$data->id);
                }
            ],
            'describe',
            'website',
            [
                'attribute'=>'pay_style',
                'contentOptions' => [
                    'style' => 'min-width: 80px;'
                ]
            ],
            //'remark',
            [
                'attribute'=>'projects',
                'format' => 'raw',
                'value'=> function($data){
                    //超链接
                    return Html::a(count($data['projects']), "/project?id=".$data->id);
                },
                'contentOptions' => [
                    'style' => 'min-width: 80px;'
                ]
            ],
            [
                'attribute'=>'customerBoffins',
                'format' => 'raw',
                'value'=> function($data){
                    //超链接
                    return Html::a(count($data['customerBoffins']), "/customer-boffin?id=".$data->id);
                },
                'contentOptions' => [
                    'style' => 'min-width: 100px;'
                ]

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
