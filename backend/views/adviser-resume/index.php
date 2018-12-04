<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdviserResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adviser Resumes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adviser-resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Adviser Resume', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'adviser_id',
            'company',
            'position',
            'begin_time',
            //'end_time',
            //'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
