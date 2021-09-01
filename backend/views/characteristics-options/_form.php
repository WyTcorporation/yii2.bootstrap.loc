<?php

use backend\models\Characteristics;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\CharacteristicsOptions;

/* @var $this yii\web\View */
/* @var $model backend\models\CharacteristicsOptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristics-options-form">

    <?php $form = ActiveForm::begin(['id'=>'characteristics-options-form']); ?>

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

    <?php
    $itemsOptions = CharacteristicsOptions::find()->all();

    foreach($itemsOptions as $key=>$itemsOption){
        $namesOptions[$key] = unserialize($itemsOption->name)[$language] .' - '.unserialize($itemsOption->characteristics->name)[$language];
    }
    ?>

    <?= $form->field($model, 'value[]')->widget(Select2::classname(), [
        'data' => $namesOptions,
        'options' => ['placeholder' => 'Выбрать  ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Поиск повторов : ');
    ?>

    <?php if (count($params) >= 1) : ?>
        <div id="characteristics" class="form-group row field-characteristics-name">
            <?php foreach ($params as $key => $value): ?>
                <div class="col-sm-2">
                    <?php if (isset($model->name) && !empty($model->name)) {
                        $data = unserialize($model->name);
                        $name = $data[$value];
                    }
                    ?>
                    <?=
                    $form->field($model, 'name', [
                        //'labelOptions'=>['class'=>'col-sm-2 col-md-2 col-lg-2'],
                        'options' => ['class' => '', 'id' => ''],
                        "template" => "{label} " . $key . " \n{input}\n{hint}\n{error}"
                    ])
                        ->textInput(['maxlength' => true, 'name' => 'CharacteristicsOptions[name][' . $value . '][]', 'value' => isset($name) && !empty($name) ? $name : ''])
                        ->label() ?>

                </div>
            <?php endforeach; ?>
            <div class="col-sm-1">
                <?= Html::Button('Удалить Характеристику', ['id' => 'delete-btn', 'class' => 'hidden btn btn-danger']) ?>
            </div>
        </div>
    <?php endif; ?>
    <div id="characteristics-input"></div>
    <div class="form-group">
        <?= Html::Button('Добавить Характеристику', ['id' => 'add-btn', 'class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Save', ['id'=>'save-btn','class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$js = <<<JS
var form = $('#characteristics-options-form');
form.on('click','#add-btn',function(e) {
        var random = Math.floor((Math.random() * 1000) + 1);
        var clone=$("#characteristics").clone().removeClass('hidden').attr('id', ''+random+'').find("input:text").val("").end().find("#delete-btn").removeClass('hidden').addClass(''+random+'').end().appendTo("#characteristics-input");
});
form.on('click',"#delete-btn",function(e) {
    var classArr = this.className.split(/\s+/),
    string = "#"+classArr[2];
    $(string).remove();
});

JS;

$this->registerJs($js);
?>