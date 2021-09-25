<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\pages\PagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>



    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'active')->dropDownList([
            Yii::t('backend/buttons', 'Not published'),
        Yii::t('backend/buttons', 'Published')
    ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

    <?= $form->field($model, 'status')->dropDownList([
             Yii::t('backend/buttons', 'No'),
        Yii::t('backend/buttons', 'Yes')
    ], ['prompt' => Yii::t('backend', 'Please select')])->label(Yii::t('backend', 'Menu status')) ?>

    <div class="form-group">
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
