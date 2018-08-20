<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view view">
    <div class="box highlight">
        <h3 class="title"><?= Html::encode($this->title) ?></h3>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'customer_id',
                'head',
                [
                    'attribute' => 'status',
                    'value' => $model->statusType($model->status),
                ],
                [
                    'attribute' => 'start_time',
                    'value' => date('Y-m-d', $model->start_time),
                ],
                [
                    'attribute' => 'create_time',
                    'value' => date('Y-m-d', $model->create_time),
                ],
                'second',
                [
                    'attribute' => 'date',
                    'value' => date('Y-m-d', $model->date),
                ],
                'fee_time',
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>
    </div>
</div>
