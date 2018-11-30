<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdviserComments */

$this->title = 'Create Adviser Comments';
$this->params['breadcrumbs'][] = ['label' => 'Adviser Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adviser-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
