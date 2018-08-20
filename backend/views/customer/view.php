<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view view">
    <div class="box highlight">
        <h3 class="title"><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'describe',
                'website',
                'pay_style',
                'remark',
                [
                    'attribute' => 'projects',
                    'format'=>'raw',
                    'value' => function($data) {
                        $result = '';
                        foreach ($data['projects'] as $key => $value) {
                            $result .= '<div>'.Html::a($value['name'], 'index.php?r=project/view&id='.$value['id']).'</div>';
                        }
                        return $result;
                    }
                ],
                [
                    'attribute' => 'customerBoffins',
                    'format'=>'raw',
                    'value' => function($data) {
                        $result = '';
                        foreach ($data['customerBoffins'] as $key => $value) {
                            $result .= Html::a($value['name_zh'], 'index.php?r=customer-boffin/view&id='.$value['id']);
                        }
                        return $result;
                    }
                ]
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>

    </div>
</div>
