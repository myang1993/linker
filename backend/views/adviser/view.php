<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Area;
use backend\models\Trade;

/* @var $this yii\web\View */
/* @var $model backend\models\Adviser */

$this->title = $model->name_zh;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advisers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adviser-view view">
    <div class="box highlight">
        <h3 class="title"><?= Html::encode($this->title) ?></h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name_zh',
                'name_en',
                [
                    'label' => '地址',
                    'value' => ($model->province ? Area::findOne($model->province)->name . ' ' : ' ') . ($model->city ? Area::findOne($model->city)->name . ' ' : ' ') . ($model->district ? Area::findOne($model->district)->name : ' '),
                ],
                [
                    'label' => '行业',
                    'value' => ($model->trade ? Trade::findOne($model->trade)->name . ' ' : ' ') . ($model->child_trade ? Trade::findOne($model->child_trade)->name . ' ' : ' '),
                ],
                [
                    'attribute' => 'source_type',
                    'value' => $model->SourceType($model->source_type),
                ],
                [
                    'attribute' => 'referee',
                    'value' => $model->getInfo(intval($model->referee)),
                    'visible' => $model->source_type == 3
                ],
                [
                    'attribute' => 'referee_fee',
                    'visible' => $model->source_type == 3
                ],
                'mobile_phone',
                'tele_phone',
                'email',
                'wechat',
                'linkedin',
                [
                    'attribute' => 'tax_type',
                    'value' => $model->tax_type == 0 ? '' : $model->taxType($model->tax_type),
                ],
                [
                    'attribute' => 'fee_phone',
                    'value' => $model->fee_phone . "（" . $model->fee_phone_type == 0 ? '' : $model->priceType($model->fee_phone_type) . "）",
                ],
                [
                    'attribute' => 'fee_road',
                    'value' => $model->fee_road . "（" . $model->fee_road_type == 0 ? '' : $model->priceType($model->fee_road_type) . "）",
                ],
                [
                    'attribute' => 'fee_face',
                    'value' => $model->fee_face . "（" . $model->fee_face_type == 0 ? '' : $model->priceType($model->fee_face_type) . "）",
                ],
                'operator'
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>

        <div class="hr"></div>

        <h3 class="title"><?= Yii::t('app', 'Career') ?></h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'company',
                'position',
                'describe',
                'expertise',
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>

        <div class="hr"></div>

        <h3 class="title"><?= Yii::t('app', 'Bank card Information') ?></h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'bank_card_no',
                'bank_card_addr',
                'bank_card_name',
                'remark',
                'pay_remark',
            ],
            'options' => ['class' => 'table table-hover table-noborder']
        ]) ?>
    </div>
</div>

<div class="project-adviser-view">

    <?php
    // $this->render('/project-adviser/_list', [
    //     'dataProvider' => $dataProvider,
    //     'searchModel' => $searchModel,
    // ])
    ?>

</div>
