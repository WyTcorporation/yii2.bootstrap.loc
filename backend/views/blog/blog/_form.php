<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\Blog */
/* @var $form yii\widgets\ActiveForm */
/* @var $params  */
/* @var $translations */

?>

<div class="blog-form">

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
    
    <?= $form->field($model, 'slug')->textInput() ?>

    <?= $form->field($model, 'active')->dropDownList(
        [
            0 => Yii::t('backend/buttons', 'Not published'),
            1 => Yii::t('backend/buttons', 'Published')
        ]
    ) ?>

    <div class="col-sm-12">
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

                        <?= $form->field($model, 'field_name[' . $value . ']')->textInput(['name' => 'Translations[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label(Yii::t('backend', 'Name')) ?>

                        <?= $form->field($model, 'field_short_content[' . $value . ']')->textarea(['name' => 'Translations[field_short_content][' . $value . ']', 'value' => $translations[$value]['short_content']->content ? $translations[$value]['short_content']->content : ''])->label(Yii::t('backend', 'Description')) ?>

                        <?= CKEditor::widget([
                            'name' => 'Translations[field_content][' . $value . ']',
                            'value' => $translations[$value]['content']->content ? $translations[$value]['content']->content : '',
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'editorOptions' => [
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по умолчанию false
                                ],
                            ]),
                        ]); ?>

                        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'name' => 'Translations[field_keywords][' . $value . ']', 'value' => $translations[$value]['keywords']->content ? $translations[$value]['keywords']->content : '']) ?>

                        <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'name' => 'Translations[field_description][' . $value . ']', 'value' => $translations[$value]['description']->content ? $translations[$value]['description']->content : '']) ?>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>

    <?php ActiveForm::end(); ?>
    <div class="clearfix"></div>
</div>
