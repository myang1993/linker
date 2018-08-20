<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Project Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-item-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'Project Id',
                'value' => 'name',
                'label' => Yii::t('app', 'Project Id'),
            ],
            [
                'attribute' => 'Client Name',
                'value' => 'name',
                'label' => Yii::t('app', 'Client Name'),
            ],

            [
                'attribute' => 'name',
                'value' => 'name',
            ],
            
            [
                'attribute' => 'Start Time',
                'value' => 'name',
                'label' => Yii::t('app', 'Start Time'),
            ],

            [
                'attribute' => 'Status',
                'value' => 'name',
                'label' => Yii::t('app', 'Status'),
            ],

            [
                'attribute' => 'Charge Person',
                'value' => 'tradeParent.name',
                'label' => Yii::t('app', 'Charge Person'),
            ],
            [
                'attribute' => 'Participants',
                'value' => 'trade.name',
                'label' => Yii::t('app', 'Participants'),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
