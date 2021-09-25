<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 18.09.2021
 * Time: 17:11
 * User: WyTcorporation, WyTcorp, WyTco
 */

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\widgets\MaskedInput;

/* @var $model */
/* @var $params */
/* @var $translations */
/* @var $options */

$this->title = Yii::t('backend', 'Stock');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-form">
    <?php $form = ActiveForm::begin(['id' => 'shop-form']); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['class' => 'btn btn-success']) ?>
        <?//= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-btn', 'class' => 'btn btn-success']) ?>
    </div>
    <div id="clone">
        <?php if (count($params) >= 1) : ?>
            <?php foreach ($params as $key => $value): ?>
                <div class="col-md-<?= count($params) >= 5 ? '2' : count($params) ?>">
                    <?= $form->field($model, 'name[title]')->textInput(['maxlength' => true, 'name' => 'Translations[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label(Yii::t('backend', 'Name').' ' . $key) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="clearfix"></div>
        <div class="col-md-2">
            <?= $form->field($model, 'array[phone][0]')->widget(
                MaskedInput::classname(), [
                    'mask' => '+380 (999)-999-99-99',
                    'options' => [
                        //'value' => $model->name['date'][0] ? $model->name['date'][0] : '',
                    ]
                ]
            )->label(Yii::t('backend/attributes', 'Phone').' 1') ?>
            <?= $form->field($model, 'array[phone][1]')->widget(
                MaskedInput::classname(), [
                    'mask' => '+380 (999)-999-99-99',
                    'options' => [
                        //'value' => $model->name['date'][0] ? $model->name['date'][0] : '',
                    ]
                ]
            )->label(Yii::t('backend/attributes', 'Phone').' 2') ?>
            <?= $form->field($model, 'array[phone][2]')->widget(
                MaskedInput::classname(), [
                    'mask' => '+380 (999)-999-99-99',
                    'options' => [
                        //'value' => $model->name['date'][0] ? $model->name['date'][0] : '',
                    ]
                ]
            )->label(Yii::t('backend/attributes', 'Phone').' 3') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'array[address]')->textInput([])->label(Yii::t('backend/attributes', 'Address')) ?>
            <?= $form->field($model, 'array[location]')->textInput([])->label(Yii::t('backend/attributes', 'Map')) ?>
            <?= $form->field($model, 'array[email]')->textInput([])->label('Email') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($options, 'content')->textarea(['rows'=>9,'cols'=>1])->label('Google '.Yii::t('backend/attributes', 'Analytics')) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <h3><?=Yii::t('backend/attributes', 'Working hours')?> :</h3>
            <div class="col-md-2">
                <p class="control-label"><?=Yii::t('backend', 'Monday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][0]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][0] ? $model->name['date'][0] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][1]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][1] ? $model->name['date'][1] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>

                <p class="control-label"><?=Yii::t('backend', 'Tuesday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][2]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                               // 'value' => $model->name['date'][2] ? $model->name['date'][2] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][3]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                               // 'value' => $model->name['date'][3] ? $model->name['date'][3] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>
            </div>
            <div class="col-md-2">
                <p class="control-label"><?=Yii::t('backend', 'Wednesday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][4]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                               // 'value' => $model->name['date'][4] ? $model->name['date'][4] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][5]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][5] ? $model->name['date'][5] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>
                <p class="control-label"><?=Yii::t('backend', 'Thursday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][6]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][6] ? $model->name['date'][6] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][7]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][7] ? $model->name['date'][7] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>
            </div>
            <div class="col-md-2">
                <p class="control-label"><?=Yii::t('backend', 'Friday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][8]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][8] ? $model->name['date'][8] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][9]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][9] ? $model->name['date'][9] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>
                <p class="control-label"><?=Yii::t('backend', 'Saturday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][10]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][10] ? $model->name['date'][10] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][11]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][11] ? $model->name['date'][11] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>
            </div>
            <div class="col-md-2">
                <p class="control-label"><?=Yii::t('backend', 'Sunday')?></p>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][12]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][12] ? $model->name['date'][12] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'Start')) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'array[date][13]')->widget(
                        MaskedInput::classname(), [
                            'mask' => '99:99',
                            'options' => [
                                //'value' => $model->name['date'][13] ? $model->name['date'][13] : ''
                            ]
                        ]
                    )->label(Yii::t('backend', 'The ending')) ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
    <div id="input"></div>
    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
var form = $('#shop-form');
$("#add-btn").on("click", function (e) { 
    var random = Math.floor((Math.random() * 1000) + 1);
        var clone = $("#clone")
         .clone()
         .removeClass('hidden').attr('id', ''+random+'')
        // .find("#delete-btn").removeClass('hidden').addClass(''+random+'').end()
        // .find(".select").addClass(''+random+'').end()
        // .find("#items").attr('id', 'items_'+random+'').val(val).end()
        // .find("#itemsList").attr('id', 'itemsList_'+random+'').val(id).end()
        // .find("#characteristicsOptions").attr('id', 'characteristicsOptions_'+random+'').end()
        // .find(".select-input").addClass(''+random+'').end()
        // .find("#delete-select-btn").addClass(''+random+'').end()
        // .find("#add-select-btn").removeClass('hidden').addClass(''+random+'').end()
        .prependTo("#input");
  // console.log(clone.find('select'));
});

form.on('click',"#delete-btn",function(e) {
    var classArr = this.className.split(/\s+/),
    string = "#"+classArr[2];
    $(string).remove();
    // console.log(string);
});

form.on('click',"#add-select-btn",function(e) {
    var classArr = this.className.split(/\s+/),
    string = classArr[2],
    original = $('.select.'+string+'').find("select").val(),
    random = Math.floor((Math.random() * 1000) + 1);
    // console.log(string);
    var clone = $('.select.'+string+'')
        .clone().removeClass(''+string+'').attr('id', ''+random+'').addClass('clearfix')
        .find("select").attr('disabled','disabled').val(original).end()
        .find('#characteristicsOptions_'+string+'').val(original).end()
        .find("#delete-select-btn").removeClass('hidden').addClass(''+random+'').end()
        .find("#add-select-btn").addClass('hidden').end()
        .appendTo('.select-input.'+string+'');
});

form.on('click',"#delete-select-btn",function(e) {
    var classArr = this.className.split(/\s+/),
    string = "#"+classArr[3];
    // console.log(string);
     $(string).remove();
});

JS;

$this->registerJs($js);
?>