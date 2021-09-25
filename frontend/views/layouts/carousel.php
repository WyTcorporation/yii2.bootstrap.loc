<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 02.09.2021
 * Time: 09:59
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\helpers\Url;

$hits = Yii::$app->session['hits'];
$language = Yii::$app->sourceLanguage;

?>
<?php if (isset($hits) && !empty($hits)): ?>
    <div class="carousel_content" id="carousel_content_last">
        <div class="container" id="swiper-viewport_last">
            <div class="row">
                <div class="col-xs-9 col-sm-6 categories_h1_div">
                    <span class="categories_h1"><?= Yii::t('frontend', 'Popular'); ?></span>
                </div>
                <div class="col-xs-3 col-sm-6 categories_h1_div">
                    <div class="carousel_buttons">
                        <div class="carousel-button-next carousel-button-next9555"></div>
                        <div class="carousel-button-prev carousel-button-prev9555 swiper-button-disabled"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="swiper-viewport">
                        <div id="carousel9555" class="swiper-container swiper-container-horizontal">

                            <div class="swiper-wrapper" id="slider">
                                <?php if (isset($hits) && !empty($hits)) : ?>
                                    <?php foreach ($hits as $hit): ?>

                                        <div class="carousel_element">
                                            <?php if ($hit['new'] != 0): ?>
                                                <div class="markNovunka">
                                                    <?= Yii::t('frontend', 'New'); ?>
                                                </div>
                                            <?php elseif ($hit['sale'] != 0): ?>
                                                <div class="markAkcia">
                                                    <?= Yii::t('frontend', 'Stock'); ?>
                                                </div>
                                            <?php elseif ($hit['hit'] != 0): ?>
                                                <div class="markHitProdaj">
                                                    <?= Yii::t('frontend', 'Bestseller'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <a href="<?= Url::to(['product/view', 'slug' => $hit['slug']]) ?>">
                                                <img
                                                        src="<?= $hit['img'] == 'no-image.png' ? Url::to('/images/no-image.png') : Url::to($hit['img']) ?>"
                                                        alt="<?= $hit['name'] ?>"
                                                        class="img-responsive"
                                                >
                                            </a>
                                            <div class="carousel_element_text">
                                                <div class="carousel_element_name">
                                                    <a href="<?= Url::to(['product/view', 'slug' => $hit['slug']]) ?>">
                                                        <?= $hit['name'] ?>
                                                    </a>
                                                </div>
                                                <div class="carousel_element_code">
                                                    <span><?= Yii::t('frontend', 'Cod'); ?>: </span><?= $hit['vendor_code'] ?>
                                                </div>
                                                <div class="carousel_element_price">
                                                    <?= $hit['price'] ?> грн.
                                                </div>
                                                <div class="carousel_element_najvnist1">
                                                    <?php if ($hit['status_stock'] == 0): ?>
                                                        <?= Yii::t('frontend/buttons', 'Not available'); ?>
                                                    <?php elseif ($hit['status_stock'] == 1): ?>
                                                        <?= Yii::t('frontend/buttons', 'In stock'); ?>
                                                    <?php elseif ($hit['status_stock'] == 2): ?>
                                                        <?= Yii::t('frontend/buttons', 'Expected'); ?>
                                                    <?php elseif ($hit['status_stock'] == 3): ?>
                                                        <?= Yii::t('frontend/buttons', 'Under the order'); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="carousel_element_cart_selected">
                                                <div class="carousel_element_cart">
                                                    <a href="<?= Url::to(['cart/add', 'id' => $hit['id']]) ?>"
                                                       data-id="<?= $hit['id'] ?>" class="add-to-cart"><?= Yii::t('frontend/buttons', 'Add to cart'); ?></a>
                                                </div>
                                                <a class="add-to-wishlist" data-id="<?= $hit['id'] ?>"
                                                   href="<?= Url::to(['wishlist/add', 'id' => $hit['id']]) ?>">
                                                    <div class="carousel_element_selected">
                                                    </div>
                                                </a>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>