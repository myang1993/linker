<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmailLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Email Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'to_emails:email',
            'cc_emails:email',
            'bcc_emails:email',
            'context:ntext',
            //'status',
            //'reason',
            //'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
