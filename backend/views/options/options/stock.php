<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 20.09.2021
 * Time: 10:40
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
/* @var $language_id */
/* @var $content_id */
/* @var $type_stock_id */
/* @var $translations */
/* @var $dataProvider */
/* @var $searchModel */

$this->title = Yii::t('backend', 'Shop');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-form">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'value' => function ($model) use ($language_id, $content_id, $type_stock_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_stock_id;
                    return $model->translation->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'banner',
                'value' => function ($model) {
                    return Html::img($model->banner, ['width' => '135px']);
                },
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>', ['/options/options/update-stock', 'id' => $model->id]);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php $form = ActiveForm::begin(['id' => 'stock-form']); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['class' => 'btn btn-success']) ?>
        <? //= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-btn', 'class' => 'btn btn-success']) ?>
    </div>
    <div id="clone">
        <div class="col-sm-12">
            <?php if (count($params) >= 1) : ?>
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-md-<?= count($params) >= 5 ? '2' : count($params) ?>">
                        <?= $form->field($model, 'name[title]')->textInput(['maxlength' => true, 'name' => 'Translations[field_name][' . $value . ']',])->label(Yii::t('backend', 'Name') . ' ' . $key) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-12">
            <?php if (count($params) >= 1) : ?>
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-md-<?= count($params) >= 5 ? '2' : count($params) ?>">
                        <?= $form->field($model, 'name[title]')->textarea(['maxlength' => true, 'name' => 'Translations[field_content][' . $value . ']',])->label(Yii::t('backend', 'Description') . ' ' . $key) ?>
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

        </div>
        <div class="clearfix"></div>
        <hr>
    </div>

    <?php ActiveForm::end(); ?>

</div>
