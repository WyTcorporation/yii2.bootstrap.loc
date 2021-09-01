<?php

use backend\models\Characteristics;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
use backend\components\MenuWidget;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $characteristics backend\models\Characteristics */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['id' => 'category-form']); ?>

    <!--    --><? //= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(Category::find()->all(),'id','name')) ; ?>

    <div class="form-group field-category-parent_id has-success">
        <label class="control-label" for="category-parent_id">Категория</label>
        <select id="category-parent_id" class="form-control" name="Category[parent_id]" aria-invalid="false">
            <option value="0">Основная</option>
            <?= MenuWidget::widget(['template' => 'select', 'model' => $model]) ?>
        </select>

        <div class="help-block"></div>
    </div>

    <?php if (count($params) >= 1) : ?>
        <?php $firstKey = array_key_first($params); ?>
        <ul class="nav nav-tabs">
            <?php foreach ($params as $key => $value): ?>
                <li class="nav-item <?= $key === $firstKey ? 'active' : '' ?>">
                    <a class="nav-link" data-toggle="tab" href="#description-<?= $value ?>"><?= $key ?></a>
                </li>
            <?php endforeach; ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#images">Изображения</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#characteristics">Характеристики</a>
            </li>
        </ul>
        <div class="tab-content">
            <?php foreach ($params as $key => $value): ?>
                <div class="tab-pane fade <?= $key === $firstKey ? 'active in' : '' ?>"
                     id="description-<?= $value ?>">
                    <?php if (isset($model->name) && !empty($model->name)) {
                        $data = unserialize($model->name);
                        $name = $data[$value];
                    }
                    if (isset($model->content) && !empty($model->content)) {
                        $data = unserialize($model->content);
                        $content = $data[$value];
                    }
                    if (isset($model->keywords) && !empty($model->keywords)) {
                        $data = unserialize($model->keywords);
                        $keywords = $data[$value];
                    }
                    if (isset($model->description) && !empty($model->description)) {
                        $data = unserialize($model->description);
                        $description = $data[$value];
                    }
                    ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'name' => 'Lang[name][' . $value . ']', 'value' => isset($name) && !empty($name) ? $name : '']) ?>

                    <?= CKEditor::widget([
                        'name' => 'Lang[content][' . $value . ']',
                        'value' => isset($content) && !empty($content) ? $content : '',
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                            'editorOptions' => [
                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false, //по умолчанию false
                            ],
                        ]),
                    ]); ?>

                    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'name' => 'Lang[keywords][' . $value . ']', 'value' => isset($keywords) && !empty($keywords) ? $keywords : '']) ?>

                    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'name' => 'Lang[description][' . $value . ']', 'value' => isset($description) && !empty($description) ? $description : '']) ?>

                </div>
            <?php endforeach; ?>
            <div class="tab-pane fade" id="characteristics">
                <?php
                $CharacteristicsItems = ArrayHelper::map(Characteristics::find()->all(), 'id', 'name');
                foreach ($CharacteristicsItems as $key => $CharacteristicsItem) {
                    $namesCharacteristicsItem[$key] = unserialize($CharacteristicsItem)[$language];
                }

                ?>
                <?= $form->field($model, 'characteristics[]')->widget(Select2::classname(), [
                    'data' => $namesCharacteristicsItem,
                    'options' => ['placeholder' => 'Выбрать ...','multiple' => true,'value' => unserialize($model->characteristics),],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        //'maximumInputLength' => 10
                    ],
                ]); ?>
            </div>
            <div class="tab-pane fade" id="images">
                <?= $form->field($model, 'imageFile')->widget(FileInput::class, [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showUpload' => false,
                    ],
                ]); ?>
                <?php if (isset($model->img) && !empty($model->img)) : ?>
                    <?= Html::img($model->img, ['alt' => $model->name, 'width' => '50']) ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="clearfix"></div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['id' => 'save-btn', 'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

