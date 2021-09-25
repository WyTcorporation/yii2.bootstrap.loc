<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 19:44
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

/* @var $translations */
/* @var $category */
/* @var $language */
/* @var $language_id */
/* @var $type_categories_id */
/* @var $type_products_id */
/* @var $type_products_models_id */
/* @var $type_characteristics_options_id */
/* @var $content_id */
/* @var $percents */
/* @var $isPjax */
/* @var $search */

use frontend\assets\CategoryAsset;
use frontend\components\MenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

CategoryAsset::register($this);


$params = Yii::$app->params['languages'];
$language = Yii::$app->language;

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Search')];
$this->params['breadcrumbs'][] = ['label' => $search];

?>

<div id="product-category" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <?php Pjax::begin(); ?>
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
        $('#filter_div .radio input[type="radio"], #filter_div .checkbox input[type="checkbox"]').on('click', function () {
            $('#submit-filter').submit();
        });
        $('#reset-radio').on('click', function () {
            var id = $(this).data("id");
            $('#radio_' + id + '').removeAttr('checked');
            $('#submit-filter').submit();
        });
        $('#reset-checkbox').on('click', function () {
            var id = $(this).data("id");
            $('#checkbox_' + id + '').removeAttr('checked');
            $('#submit-filter').submit();
        });
        $('#reset').on('click', function () {
            $('input').removeAttr('checked');
            $('#submit-filter').submit();
        });
    </script>
    <div class="row">
        <aside id="column-left" class="col-sm-3">
            <div id="category_left_menu" class="menu_side hidden-xs">
                <div class="menu_side_header">
                    <?=  Yii::t('frontend', 'Catalog'); ?>
                    <div class="menu_side_header_line"></div>
                </div>
                <div class="list-group">
                    <ul class="catalog">
                        <?= MenuWidget::widget(['template' => 'menu', 'params' => $category->id]) ?>
                    </ul>
                </div>
            </div>

        </aside>
        <div id="content" class="col-sm-9 category_content">
            <h1> </h1>
            <div class="row">
                <div class="col-sm-12 category_desc"></div>
                <div class="col-sm-12 category_desc">

                </div>
            </div>
            <div class="line2"></div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="pfi_horizontal" class="pfi_horizontal_wrapper">

                        <?php if (isset($nameProductsOptionsRadio) && !empty($nameProductsOptionsRadio)) : ?>
                            <div class="pfi_horizontal_item">
                                <button id="reset-radio" data-id="<?= $nameProductsOptionsRadio->id ?>"
                                        class="btn reset pfi_h__element">
                                    <?= unserialize($nameProductsOptionsRadio->name)[$language] ?> <i
                                            class="fa fa-times text-danger"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($nameProductsOptionsCheckbox) && !empty($nameProductsOptionsCheckbox)) : ?>
                            <?php foreach ($nameProductsOptionsCheckbox as $nameProductsOptionsCheckboxes) : ?>
                                <div class="pfi_horizontal_item">
                                    <button id="reset-checkbox" data-id="<?= $nameProductsOptionsCheckboxes->id ?>"
                                            class="btn reset pfi_h__element">
                                        <?= unserialize($nameProductsOptionsCheckboxes->name)[$language] ?>
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (isset($nameProductsOptionsCheckbox) && !empty($nameProductsOptionsCheckbox) || isset($nameProductsOptionsRadio) && !empty($nameProductsOptionsRadio)) : ?>
                            <div class="pfi_horizontal_item">
                                <button id="reset" class="btn reset btn-reset pfi_h__element">
                                    Сбросить
                                </button>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-xs-8">
                    <div class="category_form_group form-group input-group input-group-sm custom-select">
                        <label class="input-group-addon hidden-xs" for="input-sort"><?=  Yii::t('frontend', 'Sort'); ?>:</label>
                        <label class="label_for_select_category">
                            <select id="input-sort" class="select_category">
                                <option value="0" <?= empty($isPjax['pfi_sort']) ? 'selected="selected"' : '' ?>>
                                    <?=  Yii::t('frontend/buttons', 'Default'); ?>
                                </option>
                                <option value="ASC" <?= $isPjax['pfi_sort'] == 'ASC' ? 'selected="selected"' : '' ?>>
                                    <?=  Yii::t('frontend/buttons', 'Name (A - Z)'); ?>
                                </option>
                                <option value="DESC" <?= $isPjax['pfi_sort'] == 'DESC' ? 'selected="selected"' : '' ?>>
                                    <?=  Yii::t('frontend/buttons', 'Name (Z - A)'); ?>
                                </option>
                                <option value="PRICE_ASC" <?= $isPjax['pfi_sort'] == 'PRICE_ASC' ? 'selected="selected"' : '' ?>>
                                    <?=  Yii::t('frontend/buttons', 'Price (low & gt; high)'); ?>
                                </option>
                                <option value="PRICE_DESC" <?= $isPjax['pfi_sort'] == 'PRICE_DESC' ? 'selected="selected"' : '' ?>>
                                    <?=  Yii::t('frontend/buttons', 'Price (high & gt; low)'); ?>
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-5 col-xs-4">
                    <div class="category_form_group form-group input-group input-group-sm custom-select">
                        <label class="input-group-addon hidden-xs" for="input-limit"><?=  Yii::t('frontend', 'Products on page'); ?>:</label>
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
                                                <span><b><?=  Yii::t('frontend', 'Quality'); ?>:</b></span> <?= $col; ?>
                                            </div>
                                            <?php if (isset($product->models_id)) : ?>
                                                <?php
                                                $product->model->type_id = $type_products_models_id;
                                                $product->model->language_id = $language_id;
                                                $product->model->content_id = $content_id;
                                                $model_name = $product->model->translation->content;
                                                ?>
                                                <div class="list_element_description">
                                                    <span><b><?=  Yii::t('frontend', 'Model'); ?>: </b></span>
                                                    <?= $model_name; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="list_element_code">
                                                <span><?=  Yii::t('frontend', 'Cod'); ?>: </span><?= $product->vendor_code ?>
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
                                                <?= $product->price ?> грн.
                                                </span>
                                            <!--                                                <span class="price-old">226 грн.</span>-->
                                        </div>
                                        <div class="list_wishlist_div">
                                            <a href="<?= Url::to(['cart/add', 'id' => $product->id]) ?>"
                                               data-id="<?= $product->id ?>" class="buy_product_button add-to-cart">
                                                <?=  Yii::t('frontend/buttons', 'Add to cart'); ?>
                                            </a>
                                        </div>
                                        <div class="list_wishlist_div">
                                            <a class="product_page_add_to_withlist add-to-wishlist"
                                               data-id="<?= $product->id ?>"
                                               href="<?= Url::to(['wishlist/add', 'id' => $product->id]) ?>">
                                                <?=  Yii::t('frontend/buttons', 'To favorites'); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="element_text">
                                        <div class="element_name">
                                            <a href="https://mktel.ua/akkumulyatory/akkumulyatory-k-telefonam/akkumulyator-agpb009-a001-sony-xperia-p-lt22-1265mah-orig-china/">Аккумулятор
                                                <?= $name ?>
                                            </a>
                                        </div>
                                        <div class="element_quality">
                                            <b><?=  Yii::t('frontend', 'Quality'); ?>:</b> <?= $col ?>
                                        </div>
                                        <div class="element_code">
                                            <span><?=  Yii::t('frontend', 'Cod'); ?>: </span><?= $product->vendor_code ?>
                                        </div>
                                        <div class="element_price">
                                                    <span class="price-new">
                                                    <?= $product->price ?> грн.
                                                    </span>
                                            <!--<span class="price-old">226 грн.</span>-->
                                        </div>
                                        <?php if ($product->status_stock == 0): ?>
                                            <div class="element_najvnist0">
                                                <?=  Yii::t('frontend/buttons', 'Not available'); ?>
                                            </div>
                                        <?php elseif ($product->status_stock == 1): ?>
                                            <div class="element_najvnist1">
                                                <?=  Yii::t('frontend/buttons', 'In stock'); ?>
                                            </div>
                                        <?php elseif ($product->status_stock == 2): ?>
                                            <div class="element_najvnist2">
                                                <?=  Yii::t('frontend/buttons', 'Expected'); ?>
                                            </div>
                                        <?php elseif ($product->status_stock == 3): ?>
                                            <div class="element_najvnist3">
                                                <?=  Yii::t('frontend/buttons', 'Under the order'); ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                    <div class="element_cart_selected">
                                        <div class="element_cart">
                                            <a href="<?= Url::to(['cart/add', 'id' => $product->id]) ?>"
                                               data-id="<?= $product->id ?>" class="add-to-cart">
                                                <?=  Yii::t('frontend/buttons', 'Add to cart'); ?>
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
                                            <div class="product-thumb_tooltip_description">
                                                <b><?=  Yii::t('frontend', 'Model'); ?>:</b><br>
                                                <?= $model_name; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h1><?=  Yii::t('frontend', 'The product is out of stock!'); ?></h1>
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
    </div>

    <?php Pjax::end(); ?>
</div>
