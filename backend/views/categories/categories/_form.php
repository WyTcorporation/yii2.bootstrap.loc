<?php

use backend\components\MenuWidget;
use backend\models\characteristics\Characteristics;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model backend\models\categories\Categories */
/* @var $form yii\widgets\ActiveForm */
/* @var $params */
/* @var $percent */
/* @var $language_id */
/* @var $type_id */
/* @var $content_id */
/* @var $categoriesCharacteristics */
/* @var $translations */

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(['id' => 'category-form']); ?>
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
    <div class="form-group field-category-parent_id has-success">
        <label class="control-label" for="category-parent_id"><?=Yii::t('backend', 'Categories')?></label>
        <select id="category-parent_id" class="form-control" name="Categories[parent_id]" aria-invalid="false">
            <option value="0"><?=Yii::t('backend', 'Main')?></option>
            <?= MenuWidget::widget(['template' => 'select', 'model' => $model]) ?>
        </select>

        <div class="help-block"></div>
    </div>

    <div class="col-md-3">
        <?= $form->field($percent, 'array[1]')->textInput(['maxlength' => true,  'value' => $percent->array[1]? $percent->array[1] :''])->label(Yii::t('backend', 'Interest: Retail')) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($percent, 'array[2]')->textInput(['maxlength' => true,  'value' => $percent->array[2]?$percent->array[2]:''])->label(Yii::t('backend', 'Interest: Min wholesale')) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($percent, 'array[3]')->textInput(['maxlength' => true,  'value' => $percent->array[3]?$percent->array[3]:''])->label(Yii::t('backend', 'Interest: Wholesale')) ?>
    </div>
    <div class="clearfix"></div>
    <?php if (count($params) >= 1) : ?>
        <?php $firstKey = array_key_first($params); ?>
        <ul class="nav nav-tabs">
            <?php foreach ($params as $key => $value): ?>
                <li class="nav-item <?= $key === $firstKey ? 'active' : '' ?>">
                    <a class="nav-link" data-toggle="tab" href="#description-<?= $value ?>"><?= $key ?></a>
                </li>
            <?php endforeach; ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#images"><?=Yii::t('backend', 'Images')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#characteristics"><?=Yii::t('backend', 'Characteristics')?></a>
            </li>
        </ul>
        <div class="tab-content">
            <?php foreach ($params as $key => $value): ?>
                <div class="tab-pane fade <?= $key === $firstKey ? 'active in' : '' ?>"
                     id="description-<?= $value ?>">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'name' => 'Translations[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label(Yii::t('backend/attributes', 'name')) ?>

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

                    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'name' => 'Translations[field_keywords][' . $value . ']', 'value' => $translations[$value]['keywords']->content ? $translations[$value]['keywords']->content : ''])->label(Yii::t('backend/attributes', 'keywords')) ?>

                    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'name' => 'Translations[field_description][' . $value . ']', 'value' => $translations[$value]['description']->content ? $translations[$value]['description']->content : ''])->label(Yii::t('backend/attributes', 'description')) ?>

                </div>
            <?php endforeach; ?>
            <div class="tab-pane fade" id="characteristics">
                <?php
                $characteristics = Characteristics::find()->all();
                foreach ($characteristics as $key => $characteristic) {
                    $characteristic->language_id = $language_id;
                    $characteristic->type_id = $type_id;
                    $characteristic->content_id = $content_id;
                    $names[$characteristic->id] = $characteristic->translation->content;
                }

                ?>
                <?= $form->field($categoriesCharacteristics, 'array[]')->widget(Select2::classname(), [
                    'data' => $names,
                    'options' => ['placeholder' => 'Выбрать ...', 'multiple' => true, 'value' => $categoriesCharacteristics->array,],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        //'maximumInputLength' => 10
                    ],
                ])->label(Yii::t('backend', 'Characteristics')); ?>
            </div>
            <div class="tab-pane fade" id="images">
                <?= $form->field($model, 'imageFile')->widget(FileInput::class, [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showUpload' => false,
                    ],
                ])->label(Yii::t('backend/attributes', 'imageFile')); ?>
                <?php if (isset($model->img) && !empty($model->img)) : ?>
                    <?= Html::img($model->img, ['alt' => $model->name, 'width' => '50']) ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="clearfix"></div>

    <?php ActiveForm::end(); ?>

</div>
