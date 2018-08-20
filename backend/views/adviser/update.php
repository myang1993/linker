<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Adviser */

$this->title = Yii::t('app', 'Update Adviser').':'. $model->name_zh;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advisers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_zh, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="adviser-update cu">

    <h3 class="title"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'area'=> $area,
    ]) ?>

</div>
