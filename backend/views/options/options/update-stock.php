<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 20.09.2021
 * Time: 20:15
 * User: WyTcorporation, WyTcorp, WyTco
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $model */
/* @var $params */
/* @var $translations */
/* @var $dataProvider */
/* @var $searchModel */
/* @var $language */

$this->title = $translations[$language]['name']->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-form">
    <?php $form = ActiveForm::begin(['id' => 'stock-form']); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['id' => 'save-btn', 'class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?//= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-btn', 'class' => 'btn btn-success']) ?>
    </div>
    <div id="clone">
        <div class="col-sm-12">
            <?php if (count($params) >= 1) : ?>
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-md-<?= count($params) >= 5 ? '2' : count($params) ?>">
                        <?= $form->field($model, 'name[title]')->textInput(['maxlength' => true, 'name' => 'Translations[field_name][' . $value . ']','value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label('Название ' . $key) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-12">
            <?php if (count($params) >= 1) : ?>
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-md-<?= count($params) >= 5 ? '2' : count($params) ?>">
                        <?= $form->field($model, 'name[title]')->textarea(['maxlength' => true, 'name' => 'Translations[field_content][' . $value . ']','value' => $translations[$value]['content']->content ? $translations[$value]['content']->content : ''])->label('Описание ' . $key) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>

        <div class="col-sm-6">
            <?= $form->field($model, 'imageFile')->widget(FileInput::class, [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showUpload' => false,
                ],
            ])->label(false); ?>
            <?php if (isset($model->banner) && !empty($model->banner)) : ?>
                <?= Html::img($model->banner, ['alt' => $model->name, 'width' => '50']) ?>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="clearfix"></div>
</div>