<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $model  */
/* @var $languages  */

$this->title = Yii::t('backend', 'Standard languages');
?>
<div class="languages-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?= $form->field($model, 'status')->checkbox(['label'=>Yii::t('backend/buttons', 'Activate')]) ?>

    <div id="select-languages">
        <h2><?= Yii::t('backend', 'Standard languages') ?></h2>
        <div class="form-group field-options-multilanguages">
            <input type="hidden" name="Options[multilanguages]" value="">
            <select id="options-multilanguages" class="form-control" name="Options[multilanguages][]" multiple="" >
                <?php foreach ($languages as $item) : ?>
                    <option <?= $item->active == 1 ? 'selected' : '' ?> value="<?= $item->id ?>"><?= $item->name ?></option>
                <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>