<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Trade */

$this->title = Yii::t('app', 'Create Trade');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
