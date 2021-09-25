<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\web\JsExpression;

/* @var $OrdersItems */

/* @var $this yii\web\View */
/* @var $model backend\models\orders\Orders */
/* @var $form yii\widgets\ActiveForm */

?>

    <div class="orders-form">

        <?php $form = ActiveForm::begin(['id' => 'orders-form']); ?>
        <?= Html::submitButton(Yii::t('backend/buttons', 'Save'), ['id' => 'save-btn', 'class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <div class="clearfix"></div>
        <br>
        <div class="col-md-6">
            <div class="col-md-10">
                <?= $form->field($OrdersItems, 'array[]')->widget(Select2::classname(), [
                    'data' => [],
                    'options' => [
                        'multiple' => false,
                        'placeholder' => Yii::t('backend', 'Please select'),
                        'id' => 'searchProducts'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return '" . Yii::t('frontend/cart', 'Expectation') . "'; }"),
                        ],
                        'ajax' => [
                            'url' => '/admin/api/v1/products',
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(user) { return user.text; }'),
                        'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                    ],
                ])->label(Yii::t('backend/buttons', 'Search'));
                ?>
            </div>
            <div class="col-md-2">
                <br>
                <?= Html::Button('<i class="fa fa-plus"></i>', ['id' => 'add-product-btn', 'class' => 'btn btn-success']) ?>
            </div>
            <div id="clone" class="hidden">
                <input class="hidden" type="text" name="product_id[]">
                <input style="width:70%;" class="hidden" type="text" name="name[]" disabled>
                <input class="hidden" type="text" name="img[]" disabled>
                <input class="hidden" type="text" name="slug[]" disabled>
                <input class="hidden" type="text" name="price[]" disabled>
                <input style="width: 65px;" class="qty_item" type="text" name="qty_item[]">
                <input style="width: 65px;" class="sum_item" type="text" name="sum_item[]" disabled>
                <?= Html::Button('<i class="fa fa-times"></i>', ['id' => 'delete-select-btn', 'class' => 'btn btn-danger']) ?>
            </div>
            <div id="input">
                <?php if (isset($model->ordersItems) && !empty($model->ordersItems)): ?>
                    <?php for ($x = 0; $x <= count($model->ordersItems); $x++) : ?>
                        <?php if (isset($model->ordersItems[$x]) && !empty($model->ordersItems[$x])): ?>
                        <?php $item = $model->ordersItems[$x]; ?>
                        <div id="<?=$item->id?>" class="clearfix">
                            <input class="hidden" type="text" name="products[<?=$item->id?>][product_id]" value="<?=$item->product_id?>">
                            <input style="width:70%;" class="" type="text" name="name[<?=$item->id?>]" value="<?=$item->name?>" disabled="">
                            <input class="hidden" type="text" name="img[<?=$item->id?>]" value="<?=$item->img?>" disabled="">
                            <input class="hidden" type="text" name="slug[<?=$item->id?>]" value="<?=$item->slug?>" disabled="">
                            <input class="hidden" type="text" name="price[<?=$item->id?>]" value="<?=$item->price?>" disabled="">
                            <input style="width: 65px;" class="qty_item" type="text" name="products[<?=$item->id?>][qty_item]"
                                   data-sum-item="sum_item_<?=$item->id?>" data-qty="<?=$item->qty_item?>" data-price="<?=$item->price?>" value="<?=$item->qty_item?>">
                            <input style="width: 65px;" class="sum_item sum_item_<?=$item->id?>" type="text" name="sum_item[<?=$item->id?>]"
                                   value="<?=$item->sum_item?>" disabled="">
                            <?= Html::Button('<i class="fa fa-times"></i>', ['data-delete' => $item->id, 'id' => 'delete-select-btn', 'class' => 'btn btn-danger']) ?>
                        </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => isset($model->user_id) ? [$model->user_id => $model->user->username] : [],
                'options' => [
                    'multiple' => false,
                    'placeholder' => Yii::t('backend', 'Please select')
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return '" . Yii::t('frontend/cart', 'Expectation') . "'; }"),
                    ],
                    'ajax' => [
                        'url' => '/admin/api/v1/users',
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.text; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                ],
            ]);
            ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->input('email') ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '(999)-999-99-99',
                'options' => [
                    'placeholder' => '(999)-999-99-99',
                ]
            ]) ?>

            <?= $form->field($model, 'address')->textInput() ?>

            <?= $form->field($model, 'qty')->textInput() ?>

            <?= $form->field($model, 'sum')->textInput() ?>

            <?= $form->field($model, 'payment')->dropDownList([
                1 => Yii::t('backend', 'Card account'),
                2 => Yii::t('backend', 'Payment upon receipt (New Mail)'),
                3 => Yii::t('backend', 'Payment1'),
                4 => Yii::t('backend', 'Payment2')
            ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

            <?= $form->field($model, 'shipping')->dropDownList([
                1 => Yii::t('backend', 'Pickup from the store'),
                2 => Yii::t('backend', 'New mail')
            ], ['prompt' => Yii::t('backend', 'Please select')]) ?>

            <?= $form->field($model, 'status')->dropDownList([
                Yii::t('backend/buttons', 'No'),
                Yii::t('backend/buttons', 'Yes')
            ], ['prompt' => Yii::t('backend', 'Please select')]) ?>
        </div>
        <div class="clearfix"></div>
        <?php ActiveForm::end(); ?>

    </div>
<?php
$js = <<<JS
var form = $('#orders-form');

form.on('click',"#add-product-btn",function(e) {
     var id = $("#searchProducts").select2("data")[0].id,
        val = $("#searchProducts").select2("data")[0].text,
        random = Math.floor((Math.random() * 1000) + 1);
           
   $.ajax({
        type: "GET",
        url: "/admin/api/v1/products/get-product",
        data: {'id': id,'name':val},
        success: function(msg){
            var clone = $("#clone")
        .clone().removeClass('hidden').attr('id', ''+random+'').addClass('clearfix')
        .find("input[name='product_id[]']").attr('name', 'products['+random+'][product_id]').val(msg['product_id']).end()
        .find("input[name='name[]']").removeClass('hidden').attr('name', 'name['+random+']').val(msg['name']).end()
        .find("input[name='img[]']").attr('name', 'img['+random+']').val(msg['img']).end()
        .find("input[name='slug[]']").attr('name', 'slug['+random+']').val(msg['slug']).end()
        .find("input[name='price[]']").attr('name', 'price['+random+']').val(msg['price']).end()
        .find("input[name='qty_item[]']").attr('data-sum-item', 'sum_item_'+random).attr('data-qty', 1).attr('data-price', msg['price']).attr('name', 'products['+random+'][qty_item]').val(1).end()
        .find("input[name='sum_item[]']").attr('name', 'sum_item['+random+']').addClass('sum_item_'+random).val(msg['price']).end()
        .find("#delete-select-btn").attr('data-delete', random).end()
        .prependTo("#input");
            calc();
        },
        error: function(msg){
            console.log('error '+ msg);
        }
    });
});

function calc(){
     let qty_item = 0,
                sum_item = 0,
                qty = 0,
                total = 0;
     $('.qty_item').each(function( index ) {
                 let qty = parseInt($(this).data('qty')),
                    price = $(this).data('price');
                     if (price != null) {
                       total  = qty * price;
                      qty_item = qty+ qty_item;
                      sum_item = sum_item + total;
                     }
            });
            $('#orders-qty').val(qty_item);
            $('#orders-sum').val(sum_item);
}

form.on('input',".qty_item",function(e) {
    let qty = $(this).val(),
        price = $(this).data('price'),
        id = $(this).data('sum-item');
        $('.'+id+'').val(qty * price);
        $(this).data('qty',qty);
        calc();
});

form.on('click',"#delete-select-btn",function(e) {
    let id = $(this).data('delete');
    $('#'+id+'').remove();
    calc();
});

JS;

$this->registerJs($js);
?>