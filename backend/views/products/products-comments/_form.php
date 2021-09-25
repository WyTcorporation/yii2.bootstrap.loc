<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_id */

/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsComments */
/* @var $form yii\widgets\ActiveForm */

if (isset($model->product_id) && !empty($model->product_id)) {
    $model->product->language_id = $language_id;
    $model->product->content_id = $content_id;
    $model->product->type_id = $type_products_id;
    $name = $model->product->translation->content;
}

?>

<div class="products-comments-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['id' => 'save-btn', 'class' => 'btn btn-success']) ?>
    <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
    <div class="clearfix"></div>
    <br>
    <div class="col-md-6">
        <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
            'data' => isset($model->product_id) ? [$model->product_id => $name] : [],
            'options' => [
                'multiple' => false,
                'placeholder' => Yii::t('backend', 'Please select'),
                'id' => 'searchProducts'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return '" . Yii::t('frontend/cart', 'Expectation') . "'; }"),
                ],
                'ajax' => [
                    'url' => '/admin/api/v1/products',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(user) { return user.text; }'),
                'templateSelection' => new JsExpression('function (user) { return user.text; }'),
            ],
        ])->label(Yii::t('backend', 'Products'));
        ?>

        <?= $form->field($model, 'name') ?>

    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'comment') ?>

        <?= $form->field($model, 'rating')->dropDownList([
            1=>1,2=>2,3=>3,4=>4,5=>5
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
