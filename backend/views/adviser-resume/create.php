<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdviserResume */

$this->title = 'Create Adviser Resume';
$this->params['breadcrumbs'][] = ['label' => 'Adviser Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adviser-resume-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
