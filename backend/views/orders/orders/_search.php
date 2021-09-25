<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\orders\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-6">

        <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' => [],
            'options' => [
                'multiple' => false,
                'placeholder' => Yii::t('backend', 'Please select')
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return '".Yii::t('frontend/cart', 'Expectation')."'; }"),
                ],
                'ajax' => [
                    'url' => '/admin/api/v1/users',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(user) { return user.text; }'),
                'templateSelection' => new JsExpression('function (user) { return user.text; }'),
            ],
        ]);
        ?>

        <?= $form->field($model, 'name')->textInput([
                'placeholder' => Yii::t('backend/attributes', 'FIO'),
            ]
        ) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => 'test@test.test']) ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '(999)-999-99-99',
            'options' => [
                'placeholder' => '(999)-999-99-99',
            ]
        ]) ?>
    </div>

    <div class="col-md-6">

        <?= $form->field($model, 'payment')->dropDownList([
            1=>Yii::t('backend', 'Card account'),
            2=>Yii::t('backend', 'Payment upon receipt (New Mail)'),
            3=>Yii::t('backend', 'Payment1'),
            4=>Yii::t('backend', 'Payment2')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

        <?= $form->field($model, 'shipping')->dropDownList([
            1=> Yii::t('backend', 'Pickup from the store'),
            2=> Yii::t('backend', 'New mail')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

        <?= $form->field($model, 'status')->dropDownList([
                Yii::t('backend/buttons', 'No'),
            Yii::t('backend/buttons', 'Yes')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>
    </div>

    <div class="clearfix"></div>
    <div class="form-group">
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
