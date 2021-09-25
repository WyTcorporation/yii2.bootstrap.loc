<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?//= $form->field($model, 'slug') ?>

    <div class="form-group">
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?//= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?//= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
