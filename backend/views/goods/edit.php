<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?php // $form->field($model, 'sn') ?>
    <?= $form->field($model, 'cate_id')->dropDownList($cates) ?>
    <?= $form->field($model, 'brand_id')->dropDownList($brands) ?>
    <?= $form->field($model, 'market_price') ?>
    <?= $form->field($model, 'shop_price') ?>
    <?= $form->field($model, 'stock') ?>
    <?= $form->field($model, 'is_online')->radioList(\backend\models\Goods::$online) ?>
    <?= $form->field($model, 'status')->radioList(\backend\models\Goods::$st) ?>
    <?= $form->field($model, 'sort') ?>

    <?php
    // ActiveForm
    echo $form->field($model, 'logo')->widget('manks\FileInput', [
    ]);
    ?>

    <?= $form->field($intro, 'content')->textarea()?>

    <?php
    // ActiveForm
    echo $form->field($model, 'logo')->widget('manks\FileInput', [
    ]);
    ?>

    <?php
    // ActiveForm
    echo $form->field($model, 'imgFile')->widget('manks\FileInput', [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
            // 'server' => Url::to('upload/u2'),
            // 'accept' => [
            // 	'extensions' => 'png',
            // ],
        ],
    ]);
    ?>




    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>