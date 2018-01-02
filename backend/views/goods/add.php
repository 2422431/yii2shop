<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 16:59
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?=  $form->field($model, 'sn') ?>
    <?= $form->field($model, 'cate_id')->dropDownList($cates) ?>
    <?= $form->field($model, 'brand_id')->dropDownList($brands) ?>
    <?= $form->field($model, 'market_price') ?>
    <?= $form->field($model, 'shop_price') ?>
    <?= $form->field($model, 'stock') ?>
    <?= $form->field($model, 'is_online')->radioList(\backend\models\Goods::$online) ?>
    <?= $form->field($model, 'status')->radioList(\backend\models\Goods::$st) ?>
    <?= $form->field($model, 'sort') ?>
    <?= $form->field($intro, 'content')->textarea()?>
    <?php
    // ActiveForm
    echo $form->field($model, 'logo')->widget(\manks\FileInput::className(),[]);
    ?>

    <?php
    // ActiveForm
    echo $form->field($model, 'imgFile')->widget('manks\FileInput', [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
            'server' => \Yii\helpers\Url::to('upload'),
        ],

    ]); ?>




    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
