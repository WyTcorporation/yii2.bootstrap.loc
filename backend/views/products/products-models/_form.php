<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $params */
/* @var $translation */
/* @var $translations */

/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsModels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-models-form">
    <div class="row">
        <div class="col-sm-12">
            <?php $form = ActiveForm::begin(['id' => 'characteristics-form']); ?>
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
            <?= $form->field($model, 'active')->dropDownList([
                    Yii::t('backend', 'Not published'),
                Yii::t('backend', 'Published') ]
            ) ?>

            <?php if (count($params) >= 1) : ?>
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-sm-4">
                        <?= $form->field($translation, 'field_name[' . $value . ']')->textInput(['name' => 'Translation[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label('Название '.$key) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
