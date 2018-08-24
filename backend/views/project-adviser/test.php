<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => ['go-add-info'],
    'method' => 'get',
    'id' => 'form_id',
]);
?>
<?= $form->field($searchModel, 'province')->widget(\chenkby\region\Region::className(),[
    'model'=>$searchModel,
    'url'=> \yii\helpers\Url::toRoute(['get-region']),
    'province'=>[
        'attribute'=>'province',
        'items'=>\backend\models\Area::getRegion(),
        'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择省份']
    ],
    'city'=>[
        'attribute'=>'city',
        'items'=>\backend\models\Area::getRegion($searchModel['province']),
        'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择城市']
    ],
    'district'=>[
        'attribute'=>'district',
        'items'=>\backend\models\Area::getRegion($searchModel['city']),
        'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择县/区']
    ]
]);
?>
<?php \yii\widgets\ActiveForm::end(); ?>
