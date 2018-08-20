<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProjectItem */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-item-create">

    <?= $this->render('_form', [
        'model' => $model,
        'proadcu' => $proadcu,
    ]) ?>

</div>
