<?php


use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\pages\Pages */
/* @var $form yii\widgets\ActiveForm */



?>

<div class="pages-form">
    <div class="row">
        <div class="col-sm-12">
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

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label('Ссылка') ?>
            <?= $form->field($model, 'active')->dropDownList([
                Yii::t('backend/buttons', 'Not published'),
                Yii::t('backend/buttons', 'Published')
            ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

            <?= $form->field($model, 'status')->dropDownList([
                Yii::t('backend/buttons', 'No'),
                Yii::t('backend/buttons', 'Yes')
            ], ['prompt' => Yii::t('backend', 'Please select')])->label(Yii::t('backend', 'Menu status')) ?>

            <?php if (count($params) >= 1) : ?>
                <ul class="nav nav-tabs">
                    <?php foreach ($params as $key => $value): ?>
                        <li class="nav-item <?= $value === 'ru' ? 'active' : null ?>">
                            <a class="nav-link" data-toggle="tab"
                               href="#description-<?= $value ?>"><?= $key ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($params as $key => $value): ?>

                        <div class="tab-pane fade <?= $value === 'ru' ? 'active in' : null ?>"
                             id="description-<?= $value ?>">
                            <div class="col-sm-12">

                                <?= $form->field($translation, 'field_name['.$value.']')->textInput(['maxlength' => true, 'name' => 'Translations[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content :''])->label('Название') ?>

                                <?= $form->field($translation, 'field_content['.$value.']')->widget(CKEditor::className(), [
                                        'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                        'editorOptions' => [
                                            'preset' => 'full',
                                            'inline' => false,
                                        ],
                                    ]),
                                ])->label('Страница'); ?>

                                <?= $form->field($translation, 'field_keywords['.$value.']')->textInput(['maxlength' => true, 'name' => 'Translations[field_keywords][' . $value . ']', 'value' => $translations[$value]['keywords']->content ? $translations[$value]['keywords']->content :''])->label('Ключевые слова') ?>

                                <?= $form->field($translation, 'field_description['.$value.']')->textInput(['maxlength' => true, 'name' => 'Translations[field_description][' . $value . ']', 'value' => $translations[$value]['description']->content ? $translations[$value]['description']->content :''])->label('Ключевое описание') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
