<?php

use backend\components\MenuWidget;
use backend\models\categories\Categories;
use backend\models\characteristics\Characteristics;
use backend\models\characteristics\CharacteristicsOptions;
use backend\models\products\ProductsModels;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\products\Products */
/* @var $form yii\widgets\ActiveForm */
/* @var $params */
/* @var $language */
/* @var $language_id */
/* @var $productsModelsTypeId */
/* @var $categoriesTypeId */
/* @var $characteristicsTypeId */
/* @var $content_id */
/* @var $translation */
/* @var $productsModels */
/* @var $characteristicsOptionsTypeId */
/* @var $translations */
/* @var $optionArray */


?>

    <div class="product-form">
        <div class="row">
            <div class="col-sm-12">
                <?php
                $form = ActiveForm::begin(['options' => ['data-pjax' => 0, 'id' => 'product-form', 'enctype' => 'multipart/form-data']]); ?>
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
                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab"
                           href="#description"><?= Yii::t('backend', 'Description') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#props"><?= Yii::t('backend', 'The values') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#images"><?= Yii::t('backend', 'Images') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab"
                           href="#characteristicsTab"><?= Yii::t('backend', 'Characteristics') ?></a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in"
                         id="description">

                        <div class="col-sm-12">
                            <?php if (count($params) >= 1) : ?>
                                <ul class="nav nav-tabs">
                                    <?php foreach ($params as $key => $value): ?>
                                        <li class="nav-item <?= $value === 'ru' ? 'active' : null ?>">
                                            <a class="nav-link" data-toggle="tab"
                                               href="#description-<?= $value ?>"><?= $key ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content">
                                    <?php foreach ($params as $key => $value): ?>
                                        <div class="tab-pane fade <?= $value === 'ru' ? 'active in' : null ?>"
                                             id="description-<?= $value ?>">

                                            <?= $form->field($translation, 'field_name[' . $value . ']')->textInput(['name' => 'Translations[field_name][' . $value . ']', 'value' => $translations[$value]['name']->content ? $translations[$value]['name']->content : ''])->label('') ?>

                                            <?= CKEditor::widget([
                                                'name' => 'Translations[field_content][' . $value . ']',
                                                'value' => $translations[$value]['content']->content ? $translations[$value]['content']->content : '',
                                                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                                    'editorOptions' => [
                                                        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                                        'inline' => false, //по умолчанию false
                                                    ],
                                                ]),
                                            ]); ?>

                                            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'name' => 'Translations[field_keywords][' . $value . ']', 'value' => $translations[$value]['keywords']->content ? $translations[$value]['keywords']->content : '']) ?>

                                            <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'name' => 'Translations[field_description][' . $value . ']', 'value' => $translations[$value]['description']->content ? $translations[$value]['description']->content : '']) ?>

                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="props">
                        <div class="col-sm-12">

                            <?php
                            $categores = Categories::find()->all();
                            foreach ($categores as $key => $categore) {
                                $categore->language_id = $language_id;
                                $categore->type_id = $categoriesTypeId;
                                $categore->content_id = $content_id;
                                $categorenames[$categore->id] = $categore->translation->content;
                            }
                            ?>

                            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                                'data' => $categorenames,
                                'options' => ['placeholder' => Yii::t('backend', 'Please select')],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>

                            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'price')->textInput()->input('text', ['placeholder' => Yii::t('backend', 'In the format') . ' 29000.99']) ?>

                            <?= $form->field($model, 'vendor_code')->textInput()->input('text') ?>

                            <?= $form->field($model, 'status_stock')->dropDownList(
                                [
                                    0 => Yii::t('backend/buttons', 'Not available'),
                                    1 => Yii::t('backend/buttons', 'In stock'),
                                    2 => Yii::t('backend/buttons', 'Expected'),
                                    3 => Yii::t('backend/buttons', 'Under the order')
                                ]
                            ) ?>

                            <?php
                            $models = ProductsModels::find()->all();
                            foreach ($models as $key => $models_name) {
                                $models_name->language_id = $language_id;
                                $models_name->type_id = $productsModelsTypeId;
                                $models_name->content_id = $content_id;
                                $names[$models_name->id] = $models_name->translation->content;
                            }
                            ?>

                            <?= $form->field($model, 'models_id')->widget(Select2::classname(), [
                                'data' => $names,
                                'options' => ['placeholder' => Yii::t('backend', 'Please select')],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>

                            <?= $form->field($model, 'active')->dropDownList(
                                [
                                    0 => Yii::t('backend/buttons', 'Not published'),
                                    1 => Yii::t('backend/buttons', 'Published')
                                ]
                            ) ?>

                            <?= $form->field($model, 'hit')->checkbox() ?>

                            <?= $form->field($model, 'new')->checkbox() ?>

                            <?= $form->field($model, 'sale')->checkbox() ?>


                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="images">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'imageFile')->widget(FileInput::class, [
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'showUpload' => false,
                                ],
                            ])->label(false); ?>
                            <?php if (isset($model->img) && !empty($model->img)) : ?>
                                <?= Html::img($model->img, ['alt' => $model->name, 'width' => '50']) ?>
                            <?php endif; ?>

                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'imageFiles[]')->widget(FileInput::class, [
                                'options' => ['accept' => 'image/*', 'multiple' => true],
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'showUpload' => false,
                                ],
                            ])->label(false); ?>

                            <?php if (isset($model->gallery) && !empty($model->gallery)) : ?>

                                <?php foreach (unserialize($model->gallery) as $item) : ?>
                                    <?= Html::img($item, ['alt' => $model->name, 'width' => '50']) ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="characteristicsTab">
                        <div class="row">
                            <div class="col-sm-10">
                                <?php

                                $characteristics = Characteristics::find()->all();
                                foreach ($characteristics as $key => $characteristic) {
                                    $characteristic->language_id = $language_id;
                                    $characteristic->type_id = $characteristicsTypeId;
                                    $characteristic->content_id = $content_id;
                                    $characteristicsnames[$characteristic->id] = $characteristic->translation->content;
                                }

                                ?>
                                <?= $form->field(new Characteristics(), 'array[]')->widget(Select2::classname(), [
                                    'data' => $characteristicsnames,
                                    'options' => ['placeholder' => Yii::t('backend', 'Please select'), 'id' => 'select2_widget'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <div id="characteristics-clone" class="hidden">
                                    <div class="col-sm-2">
                                        <input type="text" disabled name="characteristics[]" id='items'
                                               value=""/>
                                        <input type="hidden" name="characteristicsList[]" id='itemsList'
                                               value=""/>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="select">
                                            <select name="characteristicsOptionsSelect[]" id="characteristicsOptions">
                                            </select>
                                            <input type="hidden" name="characteristicsOptionsNew[]"
                                                   id='characteristicsOptions'
                                                   value=""/>
                                            <?= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-select-btn', 'class' => 'btn btn-success']) ?>
                                            <?= Html::Button('<i class="fa fa-times"></i>', ['id' => 'delete-select-btn', 'class' => 'hidden btn btn-danger']) ?>
                                        </div>
                                        <div class="select-input">
                                            <h5><?= Yii::t('backend', 'Added') ?> :</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <?= Html::Button(Yii::t('backend', 'Delete Characteristics'), ['id' => 'delete-btn', 'class' => 'btn btn-danger']) ?>
                                    </div>
                                </div>

                                <div id="characteristics-input">
                                    <?php if (isset($optionArray) && !empty($optionArray)): ?>
                                        <?php foreach ($optionArray as $option): ?>
                                            <div id="<?= $option['characteristic']['id'] ?>" class="clearfix">
                                                <div class="col-sm-2">
                                                    <input type="text" disabled="" name="characteristics[]"
                                                           id="items_<?= $option['characteristic']['id'] ?>"
                                                           value="<?= $option['characteristic']['name'] ?>">
                                                    <input type="hidden" name="characteristicsList[]"
                                                           id="itemsList_<?= $option['characteristic']['id'] ?>"
                                                           value="<?= $option['characteristic']['id'] ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="select <?= $option['characteristic']['id'] ?>">
                                                        <select name="characteristicsOptionsSelect[]"
                                                                id="characteristicsOptions_<?= $option['characteristic']['id'] ?>">
                                                            <?php $characteristicOptions = CharacteristicsOptions::find()->where(['characteristics_id' => $option['characteristic']['id']])->all(); ?>
                                                            <?php foreach ($characteristicOptions as $characteristicOption): ?>
                                                                <?php
                                                                $characteristicOption->language_id = $language_id;
                                                                $characteristicOption->type_id = $characteristicsOptionsTypeId;
                                                                $characteristicOption->content_id = $content_id;
                                                                ?>
                                                                <option value="<?= $characteristicOption->id ?>"><?= $characteristicOption->translation->content ?></option>
                                                            <?php endforeach; ?>

                                                        </select>
                                                        <input type="hidden" name="characteristicsOptionsNew[]"
                                                               id="characteristicsOptions_<?= $option['characteristic']['id'] ?>"
                                                               value="">
                                                        <?= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-select-btn', 'class' => 'btn btn-success ' . $option['characteristic']['id']]) ?>
                                                        <?= Html::Button('<i class="fa fa-times"></i>', ['id' => 'delete-select-btn', 'class' => 'hidden btn btn-danger ' . $option['characteristic']['id']]) ?>
                                                    </div>
                                                    <div class="select-input <?= $option['characteristic']['id'] ?>">
                                                        <h5>Добавленные :</h5>
                                                        <?php foreach ($option['characteristic']['option'] as $optionItem): ?>
                                                            <div class="select clearfix"
                                                                 id="<?= $optionItem['id'] ?>">
                                                                <select name="characteristicsOptionsSelect[]"
                                                                        id="characteristicsOptions_<?= $option['characteristic']['id'] ?>"
                                                                        disabled="disabled">
                                                                    <option value="<?= $optionItem['id'] ?>"><?= $optionItem['name'] ?></option>
                                                                </select>
                                                                <input type="hidden" name="characteristicsOptionsNew[]"
                                                                       id="characteristicsOptions_<?= $option['characteristic']['id'] ?>"
                                                                       value="<?= $optionItem['id'] ?>">

                                                                <?= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-select-btn', 'class' => 'hidden btn btn-success ' . $option['characteristic']['id']]) ?>
                                                                <?= Html::Button('<i class="fa fa-times"></i>', ['id' => 'delete-select-btn', 'class' => 'btn btn-danger ' . $option['characteristic']['id'] . ' ' . $optionItem['id']]) ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <?= Html::Button('Удалить Характеристику', ['id' => 'delete-btn', 'class' => 'btn btn-danger ' . $option['characteristic']['id']]) ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS
var form = $('#product-form');
$("#select2_widget").on("change", function (e) { 
    var id = $("#select2_widget").select2("data")[0].id,
        val = $("#select2_widget").select2("data")[0].text,
        random = Math.floor((Math.random() * 1000) + 1);
        var clone = $("#characteristics-clone")
        .clone().removeClass('hidden').attr('id', ''+random+'').addClass('clearfix')
        .find("#delete-btn").removeClass('hidden').addClass(''+random+'').end()
        .find(".select").addClass(''+random+'').end()
        .find("#items").attr('id', 'items_'+random+'').val(val).end()
        .find("#itemsList").attr('id', 'itemsList_'+random+'').val(id).end()
        .find("#characteristicsOptions").attr('id', 'characteristicsOptions_'+random+'').end()
        .find(".select-input").addClass(''+random+'').end()
        .find("#delete-select-btn").addClass(''+random+'').end()
        .find("#add-select-btn").removeClass('hidden').addClass(''+random+'').end()
        .prependTo("#characteristics-input");
  // console.log(clone.find('select'));
     $.ajax({
        type: "GET",
        url: "/admin/api/v1/search-options",
        data: {'id': id},
        success: function(msg){
            //console.log(msg);
            var select = clone.find('select');
            $.each(msg,function(key, value)
                {
                    select.append('<option value=' + key + '>' + value + '</option>'); // return empty
                });
        },
        error: function(msg){
            console.log('error '+ msg);
        }
    });
  
   // console.log(id);
   // console.log(val);
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