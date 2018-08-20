<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProjectAdviser */

$this->title = Yii::t('app', 'Create Project Adviser');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Advisers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-adviser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
