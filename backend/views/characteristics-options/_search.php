<?php

use backend\components\MenuOptionsWidget;
use backend\models\Characteristics;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CharacteristicsOptionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristics-options-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'name') ?>

    <?php
    $items = ArrayHelper::map(Characteristics::find()->all(),'id','name');
    foreach($items as $key=>$item){
        $names[$key] = unserialize($item)[$language];
    }
    ?>

    <?= $form->field($model, 'characteristics_id')->widget(Select2::classname(), [
        'data' => $names,
        'options' => ['placeholder' => 'Выбрать  ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
<!---->
<!--    <div class="form-group field-category-parent_id has-success">-->
<!--        <label class="control-label" for="category-parent_id">Характеристики</label>-->
<!--        <select id="category-parent_id" class="form-control" name="CharacteristicsOptionsSearch[characteristics_id]" aria-invalid="false">-->
<!--            <option value="">Все характеристики</option>-->
<!--            --><?//= MenuOptionsWidget::widget(['template' => 'select-characteristics-options', 'model' => $model]) ?>
<!--        </select>-->
<!---->
<!--        <div class="help-block"></div>-->
<!--    </div>-->

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
