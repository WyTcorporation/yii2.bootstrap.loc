<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;


/* @var $this yii\web\View */
/* @var $model backend\models\Characteristics */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="characteristics-form">

        <?php $form = ActiveForm::begin(['id' => 'characteristics-form']); ?>

        <?php if (count($params) >= 1) : ?>
            <div id="characteristics" class="form-group row field-characteristics-name">
                <?php foreach ($params as $key => $value): ?>
                    <div class="col-sm-2">
                        <?php if (isset($model->name) && !empty($model->name)) {
                            $data = unserialize($model->name);
                            $name = $data[$value];
                            isset($name) && !empty($name) ? $old = '[old]['.$model->id.']' : $old = null;
                        }
                        ?>
                        <?=
                        $form->field($model, 'name', [
                            //'labelOptions'=>['class'=>'col-sm-2 col-md-2 col-lg-2'],
                            'options' => ['class' => '', 'id' => ''],
                            "template" => "{label} " . $key . " \n{input}\n{hint}\n{error}"
                        ])
                            ->textInput(['maxlength' => true, 'name' => 'Characteristics[name][' . $value . '][]', 'value' => isset($name) && !empty($name) ? $name : ''])
                            ->label() ?>

                    </div>
                <?php endforeach; ?>
                <div class="col-sm-2">
                    <?= $form->field($model, 'filter_status[]')->dropDownList(
                        [
                                0 => 'Нет', 1 => 'Да'
                        ],[
                                'value'=>$model->filter_status
                        ]
                    ) ?>

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
var form = $('#characteristics-form');
form.on('click','#add-btn',function(e) {
        var random = Math.floor((Math.random() * 1000) + 1);
        var clone=$("#characteristics").clone().removeClass('hidden').attr('id', ''+random+'').find("input:text").val("").end().find("#delete-btn").addClass(''+random+'').end().appendTo("#characteristics-input");
});
form.on('click',"#delete-btn",function(e) {
    var classArr = this.className.split(/\s+/),
    string = "#"+classArr[2];
    $(string).remove();
});

JS;

$this->registerJs($js);
?>