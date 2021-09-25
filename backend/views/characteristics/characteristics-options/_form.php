<?php

use backend\models\characteristics\Characteristics;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;
use backend\models\translations\Languages;

/* @var $language_id */
/* @var $content_id */
/* @var $params */
/* @var $type_id */
/* @var $translation */
/* @var $translations */

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\CharacteristicsOptions */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="characteristics-options-form">

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
            <?php
            $characteristics = Characteristics::find()->all();
            foreach ($characteristics as $key => $characteristic) {
                $characteristic->language_id = $language_id;
                $characteristic->type_id = $type_id;
                $characteristic->content_id = $content_id;
                $names[$characteristic->id] = $characteristic->translation->content;
            }
            ?>

            <?= $form->field($model, 'characteristics_id')->widget(Select2::classname(), [
                'data' => $names,
                'options' => ['placeholder' => Yii::t('backend', 'Add to filter')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
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
