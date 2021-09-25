<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 20:34
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

use frontend\components\MenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $product */

$this->params['breadcrumbs'][] = ['label' => $product['category']['name'], 'url' => ['category/view', 'slug' => $product['category']['slug']]];
$this->params['breadcrumbs'][] = ['label' => $product['name'], 'url' => ['view', 'slug' => $product['slug']]];

?>

<div id="product-product" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="product_main">
                            <div class="col-xs-5 product_main__image">
                                <div id="slider-for">
                                    <?= Html::img($product['img'] =='no-image.png'?'/images/no-image.png':$product['img'], ['alt' => $product['name'],]); ?>
                                    <?php if (isset($product['gallery']) && !empty($product['gallery'])): ?>
                                        <?php foreach ($product['gallery'] as $item) : ?>
                                            <?= Html::img($item, ['alt' => $product['name']]); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <hr>
                                <div id="slider-nav">
                                    <?= Html::img($product['img'] =='no-image.png'?'/images/no-image.png':$product['img'], ['alt' => $product['name']]); ?>
                                    <?php if (isset($product['gallery']) && !empty($product['gallery'])): ?>
                                        <?php foreach ($product['gallery'] as $item) : ?>
                                            <?= Html::img($item, ['alt' => $product['name']]); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-xs-7 product_main__info">
                                <h1><?= $product['name'] ?></h1>
                                <div class="product_main__info___description">
                                    <?= $product['content'] ?>
                                </div>
                                <ul class="list-unstyled product_main__info___specifications">
                                    <li><b><?= Yii::t('frontend', 'Cod'); ?></b>: <?= $product['vendor_code'] ?></li>
                                    <li>
                                        <b><?= Yii::t('frontend', 'Model'); ?>:</b> <?= $product['model'] ?>
                                    </li>
                                </ul>
                                <div class="product_main__info___warehouses">
                                    <p><b><?= Yii::t('frontend', 'Availability'); ?>:</b></p>
                                    <?php if ( $product['status_stock']== 0): ?>
                                        <button class="warehouse3-tooltip btn reset out_of_stock">
                                            <i class="fa fa-times-circle"></i><?= Yii::t('frontend/buttons', 'Not available'); ?>
                                        </button>
                                    <?php elseif ($product['status_stock'] == 1) : ?>
                                        <button class="warehouse2-tooltip btn reset in_stock">
                                            <i class="fa fa-check-circle"></i> <?= Yii::t('frontend/buttons', 'In stock'); ?>
                                        </button>
                                    <?php elseif ($product['status_stock'] == 2) : ?>
                                        <button class="warehouse2-tooltip btn reset in_stock"
                                                style="border-color: #337ab7">
                                            <i class="fa fa-check-circle" style="color: #337ab7"></i> <?= Yii::t('frontend/buttons', 'Expected'); ?>
                                        </button>
                                    <?php elseif ($product['status_stock'] == 3) : ?>
                                        <button class="warehouse2-tooltip btn reset in_stock"
                                                style="border-color: #3533b7">
                                            <i class="fa fa-check-circle" style="color: #3533b7"></i> <?= Yii::t('frontend/buttons', 'Under the order'); ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div id="product" class="product_buttons_div">
                                    <div class="product_main__info_price">
                                        <span>
                                            <span class="price-new"><?= $product['price'] - ($product['price']*$percent) ?> грн.</span>
                                        </span>
                                        <a class="product_page_add_to_withlist add-to-wishlist"
                                           data-id="<?= $product['id'] ?>"
                                           href="<?= Url::to(['wishlist/add', 'id' =>  $product['id'] ]) ?>">
                                            <?= Yii::t('frontend/buttons', 'To favorites'); ?>
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="quantity" value="1" size="2" id="input-quantity"
                                               class="form-control">
                                        <input type="hidden" name="product_id" value="15200">
                                        <div class="buttons_cart_and_one_click">
                                            <button type="button" class="buy_one_click" id="button_by_one_click"
                                                    data-product_name="<?= $product['name'] ?>">
                                                <?= Yii::t('frontend/buttons', 'Buy in one click'); ?>
                                            </button>
                                            <a style=" margin: 0; padding-top: 12px;text-align: center;"
                                               href="<?= Url::to(['cart/add', 'id' => $product['id']]) ?>"
                                               data-id="<?= $product['id'] ?>" class="buy_product_button add-to-cart">
                                                <?= Yii::t('frontend/buttons', 'Add to cart'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 product_main__tabs">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab-specification" data-toggle="tab">
                                <?= Yii::t('frontend', 'Specifications'); ?>
                            </a>
                        </li>
                        <li><a href="#tab-review"
                               data-toggle="tab"><?= Yii::t('frontend', 'Reviews'); ?> <?php if (isset($product['comments']) && !empty($product['comments'])) : ?>(<?= count($product['comments']) ?>)<?php else : ?>(0)<?php endif; ?></a>
                        </li>
                        <li><a href="#tab_all_spare_parts" data-product_id="15200" data-model="Xperia P LT22"
                               data-toggle="tab"><?= Yii::t('frontend', 'All spare parts for this model'); ?></a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-specification">
                            <table class="table">
                                <tbody>

                                <?php if (isset($product['productOptionsList']) && !empty($product['productOptionsList'])): ?>
                                    <?php foreach ($product['productOptionsList'] as $key=>$characteristicsProductList): ?>
                                        <tr>
                                            <td class="text-left" width="50%">
                                                <span> <?= $key; ?></span>
                                            </td>
                                            <td class="text-left">
                                                <div class="specification_value">
                                                    <?php $x=1; ?>
                                                    <?php foreach ($characteristicsProductList as $characteristicsProduct): ?>
                                                        <?php $count = count($characteristicsProductList); ?>
                                                        <?= $characteristicsProduct['name']; ?>
                                                        <?= $x == $count ? '' : '/'?>
                                                        <?php $x++; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-review">
                            <form class="form-horizontal" id="form-review">

                                <div id="review" <?php if (isset($product['comments']) && !empty($product['comments'])) : ?>style="max-height: 350px;" <?php endif; ?>>
                                    <?php if (isset($product['comments']) && !empty($product['comments'])) : ?>
                                        <?php foreach ($product['comments'] as $comment) : ?>
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td style="width: 50%;"><strong><?= $comment['name'] ?></strong></td>
                                                    <td class="text-right"> <?= date("d.m.Y", $comment['created_at']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><p><?= $comment['name'] ?></p>
                                                        <?php for ($x = 1; $x <= 5; $x++): ?>
                                                            <span class="fa fa-stack">
                                                                <?php if ($x <= $comment['rating']) : ?>
                                                                    <i class="fa fa-star fa-stack-2x"></i>
                                                                <?php endif; ?>
                                                                <i class="fa fa-star-o fa-stack-2x"></i>
                                                            </span>
                                                        <?php endfor; ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p><?= Yii::t('frontend', 'There are no reviews for this product.'); ?></p>
                                    <?php endif; ?>
                                </div>

                                <div id="review-message" style="display: none;">
                                    <p style="
                                            margin: 10px;
                                            border: 1px solid #81d139;
                                            padding: 10px;
                                            background: #81d139;
                                            color: white;
                                            border-radius: 10px;
                                        "><?= Yii::t('frontend', 'Review added'); ?></p>
                                </div>
                                <h2><?= Yii::t('frontend', 'write a feedback'); ?></h2>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-name"><?= Yii::t('frontend', 'Your name'); ?>:</label>
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>"
                                               id="input-product-id" class="form-control">
                                        <input type="text" name="name" value="" id="input-name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-review"><?= Yii::t('frontend', 'your feedback'); ?>:</label>
                                        <textarea name="text" rows="5" id="input-review"
                                                  class="form-control"></textarea>
                                        <div class="help-block"><span style="color: #FF0000;">Примечание:</span> HTML
                                            разметка не поддерживается! Используйте обычный текст.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?= Yii::t('frontend', 'Grade'); ?>:</label>
                                        &nbsp;&nbsp;&nbsp;<?= Yii::t('frontend', 'Badly'); ?> &nbsp;
                                        <input type="radio" name="rating" value="1">
                                        &nbsp;
                                        <input type="radio" name="rating" value="2">
                                        &nbsp;
                                        <input type="radio" name="rating" value="3">
                                        &nbsp;
                                        <input type="radio" name="rating" value="4">
                                        &nbsp;
                                        <input type="radio" name="rating" value="5">
                                        &nbsp;<?= Yii::t('frontend', 'Good'); ?> &nbsp;
                                    </div>
                                </div>
                                <div class="buttons clearfix">
                                    <div class="pull-left">
                                        <button type="button" id="button-review" data-loading-text="<?= Yii::t('frontend', 'loading'); ?>..."
                                                class="btn btn-primary">
                                            <?= Yii::t('frontend/buttons', 'sendButton'); ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div id="tab_all_spare_parts" class="tab-pane">
                            <div class="row">
                                <?php if (isset( $product['models'] ) && !empty($product['models'])): ?>
                                    <?php foreach ($product['models'] as $product_item): ?>

                                        <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="product-thumb">
                                                <a href="<?= Url::to(['product/view', 'slug' => $product_item['slug']]) ?>">
                                                    <?= Html::img($product_item['img'] == 'no-image.png'?'/images/no-image.png':$product_item['img'], ['alt' => $product_item['name'], 'class' => 'img-responsive']); ?>
                                                </a>
                                                <div class="element_text">
                                                    <div class="element_name">
                                                        <a href="<?= Url::to(['product/view', 'slug' => $product_item['slug']]) ?>"><?= $product_item['name'] ?></a>
                                                    </div>

                                                    <div class="element_code">
                                                        <span><?= Yii::t('frontend', 'Cod'); ?>: </span><?= $product_item['vendor_code'] ?>
                                                    </div>
                                                    <div class="element_code">
                                                        <b><?= Yii::t('frontend', 'Model'); ?>:</b> <?= $product_item['model'] ?>
                                                    </div>
                                                    <div class="element_price">
                                                        <span class="price-new">
                                                            <?= $product_item['price'] - ($product_item['price']*$percent) ?> грн.
                                                        </span>
                                                        <!--                                                        <span class="price-old">112 грн.</span>-->
                                                    </div>
                                                    <div style="background: transparent; padding-left: 0;"
                                                         class="element_najvnist1">
                                                        <?php if ($product_item['status_stock'] == 0): ?>
                                                            <button class="warehouse3-tooltip btn reset out_of_stock">
                                                                <i class="fa fa-times-circle"></i> <?= Yii::t('frontend/buttons', 'Not available'); ?>
                                                            </button>
                                                        <?php elseif ($product_item['status_stock'] == 1) : ?>
                                                            <button class="warehouse2-tooltip btn reset in_stock">
                                                                <i class="fa fa-check-circle"></i> <?= Yii::t('frontend/buttons', 'In stock'); ?>
                                                            </button>
                                                        <?php elseif ($product_item['status_stock'] == 2) : ?>
                                                            <button class="warehouse2-tooltip btn reset in_stock"
                                                                    style="border-color: #337ab7">
                                                                <i class="fa fa-check-circle"
                                                                   style="color: #337ab7"></i> <?= Yii::t('frontend/buttons', 'Expected'); ?>
                                                            </button>
                                                        <?php elseif ($product_item['status_stock'] == 3) : ?>
                                                            <button class="warehouse2-tooltip btn reset in_stock"
                                                                    style="border-color: #3533b7">
                                                                <i class="fa fa-check-circle"
                                                                   style="color: #3533b7"></i> <?= Yii::t('frontend/buttons', 'Under the order'); ?>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="element_cart_selected">

                                                    <a href="<?= Url::to(['cart/add', 'id' => $product_item['id']]) ?>"
                                                       data-id="<?= $product_item['id'] ?>" class="element_cart add-to-cart">
                                                        <?= Yii::t('frontend/buttons', 'Add to cart'); ?>
                                                    </a>

                                                    <a class="element_selected add-to-wishlist"
                                                       data-id="<?= $product_item['id'] ?>"
                                                       href="<?= Url::to(['wishlist/add', 'id' => $product_item['id']]) ?>">
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p><?= Yii::t('frontend', 'There are no accompanying parts for this model.'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imgModalLong" tabindex="-1" role="dialog" aria-labelledby="imgModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title float-left" id="imgModalLongTitle"><?= $product['name'] ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img style="width: 100%;" id="changeSrc" src="/uploads/products/2021_09_03/61319fab07587_163399636.jpg"
                     alt="<?= $product['name'] ?>">
            </div>
            <div class="modal-footer hidden"></div>
        </div>
    </div>
</div>