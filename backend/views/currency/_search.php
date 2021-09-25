<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CurrencySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<!--    --><?//= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'symbol') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'rate') ?>

    <?php  echo $form->field($model, 'decimal_places') ?>

    <?php  echo $form->field($model, 'is_default') ?>

    <?php  echo $form->field($model, 'sort') ?>

    <?php  echo $form->field($model, 'status') ?>

<!--    --><?php // echo $form->field($model, 'created_at') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'updated_at') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'created_by') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'updated_by') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'created_ip') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'updated_ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
