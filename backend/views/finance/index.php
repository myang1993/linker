<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projects');
$this->params['breadcrumbs'][] = Yii::t('app', '财务');
?>
<div class="project-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'customer_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->customer->name;
                },
            ],
            'head',
        ],
    ]); ?>
</div>
