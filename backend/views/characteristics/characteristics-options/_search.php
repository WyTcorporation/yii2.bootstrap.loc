<?php

use backend\models\characteristics\Characteristics;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $names*/

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\CharacteristicsOptionsSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="characteristics-options-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'characteristics_id')->widget(Select2::classname(), [
        'data' => $names,
        'options' => ['placeholder' => Yii::t('backend', 'Please select'), 'multiple' => false, 'value' => $model->characteristics_id ? $model->characteristics_id : '' ,],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            //'maximumInputLength' => 10
        ],
    ])->label(Yii::t('backend', 'Characteristics')); ?>

    <div class="form-group">
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
