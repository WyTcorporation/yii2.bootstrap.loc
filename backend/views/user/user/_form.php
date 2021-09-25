<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model backend\models\user\User */
/* @var $profile backend\models\user\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['id' => 'save-btn', 'class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList([
        0 => Yii::t('backend', 'Retail'),
        1 => Yii::t('backend', 'Small wholesale'),
        2 => Yii::t('backend', 'Wholesale')
    ]) ?>

    <?= $form->field($profile, 'phone')->widget(MaskedInput::class, [
        'mask' => '(999)-999-99-99',
        'options' => [
            'placeholder' => Yii::t('backend/buttons', 'yourPhoneNumber'),
        ]
    ]) ?>

    <?= $form->field($profile, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'lastname')->textInput(['maxlength' => true]) ?>


    <?php ActiveForm::end(); ?>

</div>
