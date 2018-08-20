<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Adviser */

$this->title = Yii::t('app', 'Create Adviser');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advisers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adviser-create create">

    <h3 class="title"><?= Html::encode($this->title) ?></h3>
    
    <?= $this->render('_form', [
        'model' => $model,
        'area'=> $area,
    ]) ?>

</div>
