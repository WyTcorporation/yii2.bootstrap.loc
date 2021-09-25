<?php


use backend\components\MenuWidget;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $names */
/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-4">
        <div class="form-group field-category-parent_id">
            <label style="width: 100%;" class="control-label" for="category-parent_id"><?= Yii::t('backend', 'Categories') ?></label>
            <select id="category-parent_id" class="form-control" name="ProductsSearch[category_id]">
                <option value=""><?= Yii::t('backend', 'All categories') ?></option>
                <option value="0"><?= Yii::t('backend', 'Main') ?></option>
                <?= MenuWidget::widget(['template' => 'select-products-category','model' => $model]) ?>
            </select>
        </div>
        <?= $form->field($model, 'models_id')->widget(Select2::classname(), [
            'data' => $names,
            'options' => ['placeholder' => Yii::t('backend', 'Please select'), 'multiple' => false, 'value' => $model->models_id ? $model->models_id : '' ,],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                //'maximumInputLength' => 10
            ],
        ])->label(Yii::t('backend', 'Products Models')); ?>

        <?= $form->field($model, 'price')->textInput(['placeholder' => Yii::t('backend', 'Enter text')]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'vendor_code')->textInput(['placeholder' => Yii::t('backend', 'Enter text')]) ?>

        <?= $form->field($model, 'status_stock')->dropDownList([
            Yii::t('backend/buttons', 'Not available'),
            Yii::t('backend/buttons', 'In stock'),
            Yii::t('backend/buttons', 'Expected'),
            Yii::t('backend/buttons', 'Under the order')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

        <?= $form->field($model, 'active')->dropDownList([
            Yii::t('backend/buttons', 'Published'),
            Yii::t('backend/buttons', 'Not published')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'hit')->dropDownList([
            Yii::t('backend/buttons', 'Active'),
            Yii::t('backend/buttons', 'Not Active')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

        <?= $form->field($model, 'new')->dropDownList([
            Yii::t('backend/buttons', 'Active'),
            Yii::t('backend/buttons', 'Not Active')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

        <?= $form->field($model, 'sale')->dropDownList([
            Yii::t('backend/buttons', 'Active'),
            Yii::t('backend/buttons', 'Not Active')
        ], ['prompt' => Yii::t('backend', 'Please select')]) ?>
    </div>

    <div class="form-group">
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
