<?php

use backend\components\MenuWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\categories\CategoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group field-category-parent_id has-success">
        <label style="width: 100%;" class="control-label" for="category-parent_id"><?= Yii::t('backend', 'Categories') ?></label>
        <select id="category-parent_id" class="form-control" name="CategoriesSearch[parent_id]" aria-invalid="false">
            <option value=""><?= Yii::t('backend', 'All categories') ?></option>
            <option value="0"><?= Yii::t('backend', 'Main') ?></option>
            <?= MenuWidget::widget(['template' => 'select', 'model' => $model]) ?>
        </select>

        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
