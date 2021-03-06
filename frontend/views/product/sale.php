<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 14:48
 * User: WyTcorporation
 */

use frontend\assets\CategoryAsset;
use frontend\components\MenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Sale');
/* @var $language */
/* @var $language_id */
/* @var $type_categories_id */
/* @var $type_products_id */
/* @var $type_characteristics_options_id */
/* @var $content_id */

CategoryAsset::register($this);
?>

<div id="common-home" class="container">
    <div class="row">
        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        <?php Pjax::begin(); ?>
        <?= Html::beginForm(['product/new',], 'post', ['data-pjax' => '', 'class' => 'form-horizontal', 'id' => 'product-category-form']); ?>
        <?= Html::submitButton('Получить хеш', ['id' => 'submit-filter', 'class' => 'hidden btn btn-lg btn-primary', 'name' => 'hash-button']) ?>

        <input id="pfi_limit" name="pfi_limit"
               value="<?= $isPjax['pfi_limit'] ? $isPjax['pfi_limit'] : '' ?>" type="hidden">
        <input id="pfi_sort" name="pfi_sort"
               value="<?= $isPjax['pfi_sort'] ? $isPjax['pfi_sort'] : '' ?>" type="hidden">
        <script>
            $('#input-limit').on('change', function () {
                $('#pfi_limit').val(this.value);
                $('#submit-filter').submit();
                //alert( this.value );
            });
            $('#input-sort').on('change', function () {
                $('#pfi_sort').val(this.value);
                $('#submit-filter').submit();
            });
        </script>
        <aside id="column-left" class="col-sm-3">
            <div id="category_left_menu" class="menu_side hidden-xs">
                <div class="menu_side_header">
                    <?= Yii::t('frontend', 'Catalog'); ?>
                    <div class="menu_side_header_line"></div>
                </div>
                <div class="list-group">
                    <ul class="catalog">
                        <?= MenuWidget::widget(['template' => 'menu']) ?>
                    </ul>
                </div>
            </div>
        </aside>
        <div id="content" class="col-sm-9 category_content">

            <div class="line2"></div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="pfi_horizontal" class="pfi_horizontal_wrapper">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-xs-8">
                    <div class="category_form_group form-group input-group input-group-sm custom-select">
                        <label class="input-group-addon hidden-xs" for="input-sort"><?= Yii::t('frontend', 'Sort'); ?>:</label>
                        <label class="label_for_select_category">
                            <select id="input-sort" class="select_category">
                                <option value="0" <?= empty($isPjax['pfi_sort']) ? 'selected="selected"' : '' ?>>
                                    <?= Yii::t('frontend/buttons', 'Default'); ?>
                                </option>
                                <option value="ASC" <?= $isPjax['pfi_sort'] == 'ASC' ? 'selected="selected"' : '' ?>>
                                    <?= Yii::t('frontend/buttons', 'Name (A - Z)'); ?>
                                </option>
                                <option value="DESC" <?= $isPjax['pfi_sort'] == 'DESC' ? 'selected="selected"' : '' ?>>
                                    <?= Yii::t('frontend/buttons', 'Name (Z - A)'); ?>
                                </option>
                                <option value="PRICE_ASC" <?= $isPjax['pfi_sort'] == 'PRICE_ASC' ? 'selected="selected"' : '' ?>>
                                    <?= Yii::t('frontend/buttons', 'Price (low & gt; high)'); ?>
                                </option>
                                <option value="PRICE_DESC" <?= $isPjax['pfi_sort'] == 'PRICE_DESC' ? 'selected="selected"' : '' ?>>
                                    <?= Yii::t('frontend/buttons', 'Price (high & gt; low)'); ?>
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-5 col-xs-4">
                    <div class="category_form_group form-group input-group input-group-sm custom-select">
                        <label class="input-group-addon hidden-xs" for="input-limit"><?= Yii::t('frontend', 'Products on page'); ?>:</label>
                        <label class="label_for_select_category">
                            <select id="input-limit" class="select_category">
                                <option value="16" <?= $isPjax['pfi_limit'] != 16 ? '' : 'selected="selected"' ?>>
                                    16
                                </option>
                                <option value="32" <?= $isPjax['pfi_limit'] == 32 ? 'selected="selected"' : '' ?>>
                                    32
                                </option>
                                <option value="48" <?= $isPjax['pfi_limit'] == 48 ? 'selected="selected"' : '' ?>>
                                    48
                                </option>
                                <option value="60" <?= $isPjax['pfi_limit'] == 60 ? 'selected="selected"' : '' ?>>
                                    60
                                </option>
                                <option value="100" <?= $isPjax['pfi_limit'] == 100 ? 'selected="selected"' : '' ?>>
                                    100
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 hidden-xs list_grid_buttons_sm_margin">
                    <div class="btn-group btn-group-sm">
                        <button type="button" id="list-view" data-toggle="tooltip" title=""
                                data-original-title="Список" class=""></button>
                        <button type="button" id="grid-view" data-toggle="tooltip" title="" class="active"
                                data-original-title="Сетка"></button>
                    </div>
                </div>
            </div>
            <div id="pfi_products">
                <div class="row">
                    <?php if (isset($products) && !empty($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <?php
                            $product->type_id = $type_products_id;
                            $product->language_id = $language_id;
                            $product->content_id = $content_id;
                            $name = $product->translation->content;
                            ?>
                            <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="product-thumb">
                                    <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                        <img
                                                alt="<?= $name ?>"
                                                class="img-responsive"
                                                src="<?= $product->img == 'no-image.png' ? Url::to('/images/no-image.png') : Url::to($product->img) ?>"
                                        >
                                    </a>
                                    <div class="list_element_name">
                                        <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                            <?= $name ?>
                                        </a>
                                    </div>
                                    <div class="list_element_name_desc">
                                        <?= $name ?>
                                    </div>
                                    <div class="list_element_text_content">
                                        <div class="element_text">
                                            <div class="list_element_description">
                                                <?php
                                                $col = '';
                                                for ($i = 0; $i <= count($product->characteristicsProducts); $i++) {
                                                    if($product->characteristicsProducts[$i]->characteristicsOptions->characteristics->id == 2){
                                                        $option = $product->characteristicsProducts[$i]->characteristicsOptions;
                                                        $option->type_id = $type_characteristics_options_id;
                                                        $option->language_id = $language_id;
                                                        $option->content_id = $content_id;
                                                        $col = $option->content ? $option->content:  $option->translation->content;
                                                    }
                                                }
                                                ?>
                                                <span><b><?= Yii::t('frontend', 'Quality'); ?>:</b></span> <?= $col; ?>
                                            </div>
                                            <?php if (isset($product->models_id)) : ?>
                                                <?php
                                                $product->model->type_id = $type_products_models_id;
                                                $product->model->language_id = $language_id;
                                                $product->model->content_id = $content_id;
                                                $model_name = $product->model->translation->content;
                                                ?>
                                                <div class="list_element_description">

                                                    <span><b><?= Yii::t('frontend', 'Model'); ?>: </b></span>
                                                    <?= $model_name; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="list_element_code">
                                                <span><?= Yii::t('frontend', 'Cod'); ?>: </span><?= $product->vendor_code ?>
                                            </div>
                                            <div class="element_price">
                                                    <span class="price-new">
                                                    <?= $product->price ?> грн.
                                                    </span>
                                                <!--                                                    <span class="price-old">226 грн.</span>-->
                                            </div>
                                        </div>

                                    </div>
                                    <div class="list_add_to_cart">
                                        <div class="element_price">
                                                <span class="price-new">
                                                <?= $product->price  ?> грн.
                                                </span>
                                            <!--                                                <span class="price-old">226 грн.</span>-->
                                        </div>
                                        <div class="list_wishlist_div">
                                            <a href="<?= Url::to(['cart/add', 'id' => $product->id]) ?>"
                                               data-id="<?= $product->id ?>" class="buy_product_button add-to-cart">
                                                <?= Yii::t('frontend/buttons', 'Add to cart'); ?>
                                            </a>
                                        </div>
                                        <div class="list_wishlist_div">
                                            <a class="product_page_add_to_withlist add-to-wishlist"
                                               data-id="<?= $product->id ?>"
                                               href="<?= Url::to(['wishlist/add', 'id' => $product->id]) ?>">
                                                <?= Yii::t('frontend/buttons', 'To favorites'); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="element_text">
                                        <div class="element_name">
                                            <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                                <?= $name ?>
                                            </a>
                                        </div>
                                        <div class="element_quality">
                                            <b><?= Yii::t('frontend', 'Quality'); ?>:</b> <?= $col ?>
                                        </div>
                                        <div class="element_code">
                                            <span><?= Yii::t('frontend', 'Cod'); ?>: </span><?= $product->vendor_code ?>
                                        </div>
                                        <div class="element_price">
                                                    <span class="price-new">
                                                    <?= $product->price ?> грн.
                                                    </span>
                                            <!--<span class="price-old">226 грн.</span>-->
                                        </div>
                                        <?php if ($product->status_stock == 0): ?>
                                            <div class="element_najvnist0">
                                                <?= Yii::t('frontend/buttons', 'Not available'); ?>
                                            </div>
                                        <?php elseif ($product->status_stock == 1): ?>
                                            <div class="element_najvnist1">
                                                <?= Yii::t('frontend/buttons', 'In stock'); ?>
                                            </div>
                                        <?php elseif ($product->status_stock == 2): ?>
                                            <div class="element_najvnist2">
                                                <?= Yii::t('frontend/buttons', 'Expected'); ?>
                                            </div>
                                        <?php elseif ($product->status_stock == 3): ?>
                                            <div class="element_najvnist3">
                                                <?= Yii::t('frontend/buttons', 'Under the order'); ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                    <div class="element_cart_selected">
                                        <div class="element_cart">
                                            <a href="<?= Url::to(['cart/add', 'id' => $product->id]) ?>"
                                               data-id="<?= $product->id ?>" class="add-to-cart">
                                                <?= Yii::t('frontend/buttons', 'Add to cart'); ?>
                                            </a>
                                        </div>
                                        <a class="add-to-wishlist" data-id="<?= $product->id ?>"
                                           href="<?= Url::to(['wishlist/add', 'id' => $product->id]) ?>">
                                            <div class="element_selected">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-thumb_tooltip"
                                         style="top: 372px; left: 15px; width: 189px;">

                                        <?php if (isset($product->models_id)) : ?>
                                            <div class="product-thumb_tooltip"
                                                 style="top: 372px; left: 15px; width: 189px;">

                                                <div class="product-thumb_tooltip_description">
                                                    <b><?= Yii::t('frontend', 'Model'); ?>:</b><br>
                                                    <?= $model_name; ?>
                                                </div>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h1><?= Yii::t('frontend', 'The product is out of stock!'); ?></h1>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <div class="line1_under_pagination"></div>
                    <?= LinkPager::widget([
                        'pagination' => $pages,
                        'class' => 'pagination'
                    ]); ?>
                </div>
            </div>
        </div>
        <?= Html::endForm() ?>
        <?php Pjax::end(); ?>
    </div>
</div>