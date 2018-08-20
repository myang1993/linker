<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProjectBoffin */

$this->title = Yii::t('app', 'Create Project Boffin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Boffins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-boffin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
