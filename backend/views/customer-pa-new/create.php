<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPaNew */

$this->title = 'Create Customer Pa New';
$this->params['breadcrumbs'][] = ['label' => 'Customer Pa News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-pa-new-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
