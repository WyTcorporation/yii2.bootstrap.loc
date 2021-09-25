<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\Characteristics */
/* @var $form yii\widgets\ActiveForm */

/* @var $params */
/* @var $translation */
/* @var $translations */
?>

<div class="characteristics-form">
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
            <?= $form->field($model, 'filter_status')->dropDownList(
                    [
                        Yii::t('backend/buttons', 'No'),
                        Yii::t('backend/buttons', 'Yes')
                    ], ['prompt' => Yii::t('backend', 'Add to filter')]) ?>

            <?php if (count($params) >= 1) : ?>
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-sm-4">
                        <?= $form->field($translation, 'field_name[' . $value . ']')->textInput(['name' => 'Translation[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label(Yii::t('backend/attributes', 'name').' '.$key) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
