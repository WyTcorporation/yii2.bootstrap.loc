<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 19:11
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

use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use frontend\components\MenuWidget;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$params = Yii::$app->params['languages'];
$language = Yii::$app->language;

?>

<div id="common-home" class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($stocks) && !empty($stocks)): ?>
            <div class="swiper-wrapper" id="mainSlider">
                <?php foreach ($stocks as $stock) : ?>
                    <div>
                        <img
                                src="<?= $stock['image'] == 'no-image.png' ? Url::to('/images/no-image.png') : Url::to($stock['image']) ?>"
                                alt="<?= $stock['name'] ?>"
                                class="img-responsive"
                        >
                        <h1><?= $stock['name'] ?></h1>
                        <p><?= $stock['content'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <aside id="column-left" class="col-sm-3">
            <div id="category_left_menu" class="menu_side hidden-xs">
                <div class="menu_side_header">
                    КАТАЛОГ
                    <div class="menu_side_header_line"></div>
                </div>
                <div class="list-group">
                    <ul class="catalog">
                        <?= MenuWidget::widget(['template' => 'menu']) ?>
                    </ul>
                </div>
            </div>
            <div class="menu_side left_contact_info_block hidden-xs">
                <div class="menu_side_header">
                    Контакты
                    <div class="menu_side_header_line"></div>
                </div>
                <div class="left_contact_info">
                    <?php if (isset($shops) && !empty($shops)): ?>
                        <?php foreach ($shops as $shop) : ?>
                            <div>
                                <span class="left_contact_header"><?= $shop['name'] ?></span>
                                <?php foreach ($shop['phones'] as $phone) : ?>
                                <span class="left_contact_phone"><?= $phone ?></span>
                                <?php endforeach; ?>
                                <span class="left_contact_addr"><?= $shop['address'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            <div class="row">
                <div class="col-xs-12 categories_h1_div">
                    <span class="categories_h1"><?=  Yii::t('frontend', 'Categories'); ?></span>
                </div>
            </div>
            <div class="row">
                <?php if (isset($category) && !empty($category)): ?>
                    <?php foreach ($category as $cat) : ?>
                        <?php
                        $cat->type_id = $type_id;
                        $cat->language_id = $language_id;
                        $cat->content_id = $content_id;
                        ?>
                        <div class="category-grid col-lg-3 col-md-3 col-sm-4 col-xs-6 text-center">
                            <div class="category-thumb">
                                <div class="image">
                                    <a href="<?= Url::to(['category/view', 'slug' => $cat->slug]) ?>">
                                        <img
                                                src="<?= $cat->img ?>"
                                                alt="<?= $cat->translation->content ?>"
                                                title="<?= $cat->translation->content ?>" class="img-responsive">
                                    </a>
                                </div>
                                <div class="category_name">
                                    <a href="<?= Url::to(['category/view', 'slug' => $cat->slug]) ?>">
                                        <?= $cat->translation->content ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="hidden">
    <div class="container">
        <h1>
            Запчасти и комплектующие для мобильных устройств - MKTEL
        </h1>
        <p><br>Рынок мобильных телефонов и смартфонов растет из года в год. Вместе с этим растет и потребность в
            качественных запчастях и комплектующих для ремонта этих гаджетов. Именно эту миссию выполняет наша компания
            МКТЕЛ.</p>
        <p>Наш магазин уже более 10 лет занимается продажей запчастей и комплектующих для различных смартфонов,
            мобильных телефонов и планшетов. Поставляем детали, как на оригинальные, так и на китайские аппараты
            различных брендов — Samsung, Apple, Nokia, LG, Fly, Xiaomi, Meizu и др. </p>
        <p>В нашем интернет магазине Вы найдете запчасти для мобильной техники максимально широкого ассортимента. У нас
            можно купить или заказать дисплеи, сенсорные модули (тачскрины), корпуса и корпусные части, аккумуляторы, а
            также различные динамики, микрофоны, камеры, шлейфы и много других комплектующих. </p>
        <p>Наша компания успешно сотрудничает с различными группами покупателей — от частных мастеров и ремонтников, до
            специализированных сервисных центров по всей Украине. Лояльная ценовая политика, широкий ассортимент и
            отличное качество позволяют нам занимать достойное место на рынке запчастей и комплектующих для мобильной
            техники. Мы гордимся своей репутацией и нацелены на долгосрочное и плодотворное сотрудничество со своими
            клиентами. </p>
        <p align="right">С ув. компания МКТЕЛ.<br></p>
    </div>
</div>
<div class="under_footer_line"></div>
<div class="under_footer_block hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="under_footer_header">
                    <span>ИНТЕРНЕТ МАГАЗИН MKTEL</span>
                </div>
                <div class="under_footer_header_text">
                    <span>Аксессуары и комплектующие к смартфонам, планшетам цифровой фототехнике</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 text-center">
                <div class="under_footer_header_sec">
                    <div class="under_footer_header_sec_in under_footer_header_sec1">
                        Более<br><span class="under_footer_span">8 000</span><br>наименований
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="under_footer_header_sec">
                    <div class="under_footer_header_sec_in under_footer_header_sec2">
                        <span class="under_footer_span">56</span><br>популярных<br>брендов
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="under_footer_header_sec">
                    <div class="under_footer_header_sec_in under_footer_header_sec3">
                        Возврат в течение<br><span class="under_footer_span">30</span><br>дней
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="under_footer_header_sec">
                    <div class="under_footer_header_sec_in under_footer_header_sec4">
                        Доставка за<br><span class="under_footer_span">1-3</span><br>дня
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
