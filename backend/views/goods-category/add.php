<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\GoodsCategory */
/* @var $form ActiveForm */
?>
<div class="goods-category-add">

    <?php   $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'p_id')->dropDownList($cates, ['prompt' => '顶级分类'])->label("分类") ?>

    <?= $form->field($model, 'intro') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end();
    //    var_dump($cates);exit;
    ?>




</div><!-- goods-category-add -->