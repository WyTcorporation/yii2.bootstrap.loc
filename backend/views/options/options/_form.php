<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\translations\Type;

/* @var $this yii\web\View */
/* @var $model backend\models\options\Options */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="options-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id', 'type')) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(
        [
            0 => 'Выкл',
            1 => 'Вкл',
        ]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            0 => 'Не активный',
            1 => 'Активный',
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
