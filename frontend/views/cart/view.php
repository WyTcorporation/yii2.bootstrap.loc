<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 16.03.2020
 * Time: 17:21
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\Breadcrumbs;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $productList */
/* @var $order */
/* @var $user */
/* @var $order_id */

$params = Yii::$app->params['languages'];
$language = Yii::$app->language;

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Basket');

?>
<?php Pjax::begin(); ?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
    ],
]) ?>

<div class="container cart-container" id="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <?php if (!empty($session['cart'])): ?>
            <div id="content" class="col-sm-12 ">
                <div id="d_quickcheckout">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="qc-col-2 col-md-6  ">
                                    <div id="shipping_method" class="qc-step" data-col="2 " data-row="1 ">
                                        <form id="shipping_method_form">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <span class="icon">
                                                            <i class="fa fa-truck"></i>
                                                        </span>
                                                        <span class="text">
                                                            <?=  Yii::t('frontend/cart', 'Delivery method'); ?>
                                                        </span>
                                                    </h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="shipping_method_list">
                                                        <strong class="title">
                                                            <?=  Yii::t('frontend/cart', 'Pickup'); ?>
                                                        </strong>
                                                        <div class="radio-input radio">
                                                            <label for="pickup">
                                                                <input type="radio" name="shipping_method"
                                                                       value="pickup.pickup" id="pickup"
                                                                       checked="checked" data-refresh="5"
                                                                       class="styled">
                                                                <span class="text">
                                                                    <?=  Yii::t('frontend/cart', 'Pickup from the store'); ?>
                                                                </span><span
                                                                        class="price">0 грн.</span></label>
                                                        </div>
                                                        <strong class="title">Новая почта</strong>
                                                        <div class="radio-input radio">
                                                            <label for="npradio">
                                                                <input type="radio" name="shipping_method"
                                                                       value="npradio"
                                                                       id="npradio" data-refresh="5" class="styled">
                                                                <span class="text">
                                                                    <?=  Yii::t('frontend/cart', 'New mail'); ?>
                                                                </span><span
                                                                        class="price">35 грн.</span></label>
                                                        </div>
                                                        <div id="np">
                                                            <hr>
                                                            <?= Select2::widget([
                                                                'name' => 'getRegions',
                                                                'data' => [],
                                                                'options' => [
                                                                    'multiple' => false,
                                                                    'placeholder' => Yii::t('frontend/cart', 'Search area'),
                                                                    'id' => 'getRegions'
                                                                ],
                                                                'pluginEvents' => [
                                                                    "change" => "function() {  clearSelect2('getCities','getWarehouses'); }",
                                                                    "select2:opening" => "function() { clearSelect2('getCities','getWarehouses'); }",
                                                                ],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'minimumInputLength' => 3,
                                                                    'language' => [
                                                                        'errorLoading' => new JsExpression("function () { return '".Yii::t('frontend/cart', 'Expectation')."'; }"),
                                                                    ],
                                                                    'ajax' => [
                                                                        'url' => '/admin/api/v1/nova-poshta-api-list/regions',
                                                                        'dataType' => 'json',
                                                                        'data' => new JsExpression('function(params) { return {q:params.term,type: "public"}; }')
                                                                    ],
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                                                ],
                                                            ]);
                                                            ?>
                                                            <hr>
                                                            <?= Select2::widget([
                                                                'name' => 'getCities',
                                                                'data' => [],
                                                                'options' => [
                                                                    'multiple' => false,
                                                                    'placeholder' => Yii::t('frontend/cart', 'City search'),
                                                                    'id' => 'getCities'
                                                                ],
                                                                'pluginEvents' => [
                                                                    "change" => "function() { clearSelect2('getWarehouses'); }",
                                                                    "select2:opening" => "function() { clearSelect2('getWarehouses'); }",
                                                                ],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'minimumInputLength' => 3,
                                                                    'language' => [
                                                                        'errorLoading' => new JsExpression("function () { return '".Yii::t('frontend/cart', 'Expectation')."'; }"),
                                                                    ],
                                                                    'ajax' => [
                                                                        'url' => '/admin/api/v1/nova-poshta-api-list/cities',
                                                                        'dataType' => 'json',
                                                                        'data' => new JsExpression('function(params) { return {q:params.term, id: functionRegionId(), name: functionRegionName()}; }')
                                                                    ],
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                                                ],
                                                            ]);
                                                            ?>
                                                            <hr>
                                                            <?= Select2::widget([
                                                                'name' => 'getWarehouses',
                                                                'data' => [],
                                                                'options' => [
                                                                    'multiple' => false,
                                                                    'placeholder' => Yii::t('frontend/cart', 'Branch search'),
                                                                    'id' => 'getWarehouses'
                                                                ],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'minimumInputLength' => 3,
                                                                    'language' => [
                                                                        'errorLoading' => new JsExpression("function () { return '".Yii::t('frontend/cart', 'Expectation')."'; }"),
                                                                    ],
                                                                    'ajax' => [
                                                                        'url' => '/admin/api/v1/nova-poshta-api-list/warehouses',
                                                                        'dataType' => 'json',
                                                                        'data' => new JsExpression('function(params) { return {q:params.term, region_id: functionRegionId(), region_name: functionRegionName(), city_id : functionCityId(), city_name : functionCityName()}; }')
                                                                    ],
                                                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="qc-col-3 col-md-6 ">
                                    <div id="payment_method" class="qc-step" data-col="3 " data-row="1 ">

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                            <span class="icon">
                                                                <i class="fa fa-credit-card"></i>
                                                            </span>
                                                    <span class="text">
                                                        <?=  Yii::t('frontend/cart', 'Payment method'); ?>
                                                    </span>
                                                </h4>
                                            </div>
                                            <div class="panel-body">
                                                <div id="payment_method_list" class="">
                                                    <div class="radio-input radio">
                                                        <label for="card_account">
                                                            <input type="radio" name="Orders[payment]"
                                                                   value="1" id="card_account"
                                                                   checked="checked" class="styled"
                                                                   data-refresh="6">
                                                            <?=  Yii::t('frontend/cart', 'Card account'); ?>
                                                            <span class="price"></span>

                                                        </label>
                                                    </div>

                                                    <div class="radio-input radio">
                                                        <label for="cod1">
                                                            <input type="radio" name="Orders[payment]"
                                                                   value="3"
                                                                   id="cod1" class="styled" data-refresh="6">
                                                            <?=  Yii::t('frontend/cart', 'Payment1'); ?>
                                                            <span class="price"></span>
                                                        </label>
                                                    </div>
                                                    <div class="radio-input radio">
                                                        <label for="cod2">
                                                            <input type="radio" name="Orders[payment]"
                                                                   value="4"
                                                                   id="cod2" class="styled" data-refresh="6">
                                                            <?=  Yii::t('frontend/cart', 'Payment2'); ?>
                                                            <span class="price"></span>
                                                        </label>
                                                    </div>
                                                    <div class="radio-input radio">
                                                        <label for="cod">
                                                            <input type="radio" name="Orders[payment]"
                                                                   value="2"
                                                                   id="cod" class="styled" data-refresh="6">
                                                            <?=  Yii::t('frontend/cart', 'Payment upon receipt (New Mail)'); ?>
                                                            <span class="price"></span>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="qc-col-4 col-md-12">
                                    <div id="cart_view" class="qc-step" data-col="4" data-row="2">

                                        <div class="panel panel-default ">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <span class="icon">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </span>
                                                    <span class="text">
                                                        <?=  Yii::t('frontend', 'Basket'); ?>
                                                    </span>
                                                </h4>
                                            </div>

                                            <div class="qc-checkout-product panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered qc-cart">
                                                        <thead>
                                                        <tr>
                                                            <td class="qc-image "><?=  Yii::t('frontend', 'Image'); ?>:</td>
                                                            <td class="qc-image"><?=  Yii::t('frontend', 'Code'); ?>:</td>
                                                            <td class="qc-name "><?=  Yii::t('frontend', 'Name'); ?>:</td>
                                                            <td class="qc-quantity "><?=  Yii::t('frontend', 'Quantity'); ?>:</td>
                                                            <td class="qc-price hidden-xs "><?=  Yii::t('frontend/cart', 'Price per piece'); ?>:</td>
                                                            <td class="qc-total "><?=  Yii::t('frontend', 'Total'); ?>:</td>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <?php $x = 0; ?>
                                                        <?php foreach ($productList['products'] as $id => $item): ?>
                                                            <tr id="delete_<?= $item['id'] ?>">
                                                                <td class="qc-image ">
                                                                    <a href="<?= Url::to(['/product/view', 'slug' => $item['slug']]) ?>">
                                                                        <img class="img-responsive" width="100px"
                                                                             src="<?= $item['img']=='no-image.png' ? '/images/no-image.png' : $item['img'] ?>"
                                                                             alt="<?= $item['name'] ?>">
                                                                    </a>
                                                                </td>
                                                                <td class="qc-image"><?= $item['vendor_code'] ?></td>
                                                                <td class="qc-name ">
                                                                    <a href="<?= Url::to(['/product/view', 'slug' => $item['slug']]) ?>">
                                                                        <?= $item['name'] ?>
                                                                    </a>
                                                                    <div class="qc-name-price visible-xs-block ">
                                                                        <small>
                                                                            <span class="title"><?=  Yii::t('frontend/cart', 'Price per piece'); ?>:</span>
                                                                            <span class="text"><?= $item['price'] ?> грн.</span>
                                                                        </small>
                                                                    </div>
                                                                </td>
                                                                <td class="qc-quantity ">
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-btn">
                                                                            <?= Html::Button('<i class="fa fa-chevron-down"></i>', [
                                                                                'id' => 'btn_decrease',
                                                                                'class' => 'btn btn-primary decrease',
                                                                                'data-id' => $item['id']
                                                                            ]) ?>
                                                                        </span>
                                                                        <input type="text" data-mask="99999"
                                                                               value="<?= $item['qty'] ?>"
                                                                               data-id="<?= $item['id'] ?>"
                                                                               class="qc-product-qantity qc-product-qantity_<?= $item['id'] ?> form-control text-center"
                                                                               name="Products[<?= $x; ?>][qty]"
                                                                               autocomplete="off" maxlength="5">
                                                                        <input type="hidden"
                                                                               name="Products[<?= $x; ?>][id]"
                                                                               value="<?= $item['id'] ?>">
                                                                        <span class="input-group-btn">
                                                                                  <?= Html::Button('<i class="fa fa-chevron-up"></i>', [
                                                                                      'id' => 'btn_increase',
                                                                                      'class' => 'btn btn-primary increase',
                                                                                      'data-id' => $item['id']
                                                                                  ]) ?>
                                                                                  <?= Html::Button('  <i class="fa fa-times" aria-hidden="true"></i>', [
                                                                                      'id' => 'btn_increase',
                                                                                      'class' => 'btn btn-danger del-item',
                                                                                      'data-id' => $item['id']
                                                                                  ]) ?>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="qc-price_<?= $item['id'] ?> hidden-xs ">
                                                                    <span><?= $item['price'] ?></span>
                                                                    грн.
                                                                </td>
                                                                <td class="calc qc-total_<?= $item['id'] ?> ">
                                                                    <span><?= $item['price'] * $item['qty'] ?></span>
                                                                    грн.
                                                                </td>
                                                            </tr>
                                                            <?php $x++; ?>
                                                        <?php endforeach; ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="form-horizontal">
                                                    <div class="form-horizontal qc-totals">

                                                        <div class="row">
                                                            <label class="col-sm-9 col-xs-6 control-label"><?=  Yii::t('frontend/cart', 'Sum'); ?></label>
                                                            <div class="col-sm-3 col-xs-6 form-control-static text-right">
                                                                <div id="x-total">
                                                                    <span><?= $session['cart.sum'] ?></span> грн.
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-sm-9 col-xs-6 control-label"><?=  Yii::t('frontend/cart', 'Total'); ?></label>
                                                            <div class="col-sm-3 col-xs-6 form-control-static text-right">
                                                                <div id="z-total">
                                                                    <span><?= $session['cart.sum'] ?></span> грн.
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div id="payment_view" class="qc-step" data-col="4" data-row="2">

                                        <div class="col-md-6 pull-right">
                                            <?= $form->field($order, 'name')->textInput(['value' => $user->profile->firstname ? $user->profile->firstname . ' , ' . $user->profile->lastname : $user->username]) ?>
                                            <?= $form->field($order, 'email')->textInput(['value' => $user->email]) ?>
                                            <?= $form->field($order, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                                                'mask' => '(999)-999-99-99',
                                            ]) ?>
                                            <?= $form->field($order, 'address')->hiddenInput(['value' => ''])->label(false) ?>
                                            <?= $form->field($order, 'qty')->hiddenInput(['value' => $session['cart.qty']])->label(false) ?>
                                            <?= $form->field($order, 'sum')->hiddenInput(['value' => $session['cart.sum']])->label(false) ?>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="buttons">
                                            <div class="pull-right">

                                                <?= Html::submitButton(Yii::t('frontend/cart', 'Confirmation of an order'), ['class' => 'add-order btn btn-primary']) ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <h1><?=  Yii::t('frontend/cart', 'Cart is empty'); ?></h1>
        <?php endif; ?>
    </div>
</div>
<script>

    $(document).on('pjax:success', function () {
        <?php if($order_id != 0): ?>
        $.ajax({
            url: '/cart/payment',
            data: {id: <?=$order_id?>},
            type: 'GET',
            success: function (res) {
                showPayment(res)
            },
            error: function () {
                alert('Error')
            }
        });
        return false;
        <?php endif; ?>
    });

    function showPayment(cart) {
        $('#payment .modal-body').html(cart);
        $('#payment').modal();
    }
</script>
<?php $form = ActiveForm::end() ?>
<?php Pjax::end(); ?>
<div class="mb-1"></div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=  Yii::t('frontend', 'Privacy Policy'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?=  Yii::t('frontend', 'Privacy Policy Text'); ?>
            </div>
        </div>
    </div>
</div>

