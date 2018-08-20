<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CustomerBoffin */

$this->title = Yii::t('app', 'Create Customer Boffin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer Boffins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-boffin-create">

    <h3 class="title"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
