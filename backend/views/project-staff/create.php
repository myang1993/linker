<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProjectStaff */

$this->title = Yii::t('app', 'Create Project Staff');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-staff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
