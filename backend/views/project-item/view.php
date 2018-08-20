<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-item-view view">

    <div class="box highlight">
        <h3 class="title">项目名称</h3>
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
                [
                    'label' => 'Client Name',
                    'value' => $model->name,
                    'contentOptions' => ['style'=> 'width:70%'],
                ],
                [
                    'label' => 'Project Name',
                    'value' => $model->trade->name,
                ],
                [
                    'label' => 'Start Time',
                    'value' => $model->tradeParent->name,
                ],
                [
                    'label' => 'Status',
                    'value' => $model->tradeParent->name,
                ],
                [
                    'label' => 'Charge Person',
                    'value' => $model->tradeParent->name,
                ],
                [
                    'label' => 'Participants',
                    'value' => $model->tradeParent->name,
                ],
                [
                    'label' => 'Consultants',
                    'value' => $model->tradeParent->name,
                ],
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>
    </div>

    <div class="box highlight">
        <h3 class="title">访谈信息</h3>
        
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Interview Time',
                    'value' => $model->name,
                    'contentOptions' => ['style'=> 'width:70%'],
                ],
                [
                    'label' => 'Interview Date',
                    'value' => $model->trade->name,
                ],
                [
                    'label' => 'Charge Time',
                    'value' => $model->tradeParent->name,
                ],
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>

        
    </div>

</div>
