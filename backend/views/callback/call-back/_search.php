<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model backend\models\callback\CallBackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="call-back-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'telephone')->widget(MaskedInput::class, [
        'mask' => '(999)-999-99-99',
        'options' => [
            'placeholder' => '(999)-999-99-99',
        ]
    ]) ?>


    <?= $form->field($model, 'status')->dropDownList([
        Yii::t('backend/buttons', 'No'),
        Yii::t('backend/buttons', 'Yes')
    ], ['prompt' => Yii::t('backend', 'Please select')])->label(Yii::t('backend/attributes', 'Status')) ?>

    <div class="form-group">
<!--        --><?//= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
