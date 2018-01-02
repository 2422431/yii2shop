<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form ActiveForm */
?>
<div class="article-add">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'category_id')->dropDownList($cate) ?>
    <?= $form->field($model, 'status')->radioList(\backend\models\Article::$statuslist)?>

    <?= $form->field($model, 'sort') ?>
    <?= $form->field($model, 'intro') ?>
    <?= $form->field($model, 'content')->textarea(['rows'=>10]) ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>