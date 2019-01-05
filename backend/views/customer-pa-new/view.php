<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPaNew */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Pa News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-pa-new-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'application',
            'application_address',
            'study_leadey_address',
            'study_leadey',
            'telephone',
            'leadey_telephone',
            'application_email:email',
            'leadey__email:email',
            'position',
            'page_id',
            'create_time',
        ],
    ]) ?>

</div>
