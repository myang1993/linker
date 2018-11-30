<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdviserCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adviser Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adviser-comments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Adviser Comments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'comments',
            'comment_uid',
            'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
