<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 17:11
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

use frontend\components\MenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;

$session = Yii::$app->session;
$contacts = $session['contacts'][0];
?>
<nav id="top">
    <?= $this->render('auction', []); ?>
    <?= $this->render('menu', []); ?>
</nav>
<header>
    <div class="container mobile visible-sm">
        <div class="row">
            <div class="col-sm-6">
                <div id="logo"><a href="<?= Url::to(['/']) ?>"><img
                                src="/images/logo.jpg.pagespeed.ce.hUEwdMoxg2.jpg"
                                title="<?= Yii::$app->params['shopTitle'] ?>" alt="<?= Yii::$app->params['shopTitle'] ?>" class="img-responsive"></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="top_zvor_dzvinok" data-toggle="modal" data-target="#top_zvor_dzvinok">
                    <?=  Yii::t('frontend/buttons', 'backCall'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="top_contacts">

                    <?php if (isset($contacts['phones']) && !empty($contacts['phones'])): ?>
                    <?php for ($x=0;$x<=count($contacts['phones']);$x++) :?>
                    <span style="font-family: Tahoma; font-size: 14px;"><?= $contacts['phones'][$x] ?></span>
                    <br style="font-family: Tahoma;">
                    <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="top_schedule">
                    <b style="font-family: Tahoma;">
                        <span style="font-family: Tahoma; font-size: 14px;">&nbsp;</span>
                        <br
                                style="font-family: Tahoma;">
                        <?php if (isset($contacts['date']) && !empty($contacts['date'])): ?>
                            <?php $y=0; ?>
                            <?php foreach($contacts['date'] as $key=> $date) :?>
                                <span><?= $key ?> <?= $date ?></span>
                                <?php $y++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </b><br>
                </div>
            </div>
        </div>
    </div>
    <div class="container desctope hidden-xs hidden-sm">
        <div class="row">
            <div class="col-sm-3">
                <div id="logo"><a href="<?= Url::to(['/']) ?>"><img
                                src="/images/logo.jpg.pagespeed.ce.hUEwdMoxg2.jpg"
                                title="<?= Yii::$app->params['shopTitle'] ?>" alt="<?= Yii::$app->params['shopTitle'] ?>" class="img-responsive"></a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top_contacts hidden-xs hidden-sm">

                    <span style="font-family: Tahoma; font-size: 14px;">&nbsp;</span>
                    <br
                            style="font-family: Tahoma;">

                    <?php if (isset($contacts['phones']) && !empty($contacts['phones'])): ?>
                        <?php for ($x=0;$x<=count($contacts['phones']);$x++) :?>
                            <span style="font-family: Tahoma; font-size: 14px;"><?= $contacts['phones'][$x] ?></span>
                            <br style="font-family: Tahoma;">
                        <?php endfor; ?>
                    <?php endif; ?>

                </div>
            </div>
            <div class="col-sm-3">
                <div class="top_schedule">
                    <b style="font-family: Tahoma;font-size: 14px;">
                        <span style="font-family: Tahoma; font-size: 14px;">&nbsp;</span>
                        <br
                                style="font-family: Tahoma;">
                        <?php if (isset($contacts['date']) && !empty($contacts['date'])): ?>
                            <?php $y=0; ?>
                            <?php foreach($contacts['date'] as $key=> $date) :?>
                                <span><?= $key ?> <?= $date ?></span>
                                <?php $y++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </b>
                    <br>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top_zvor_dzvinok" data-toggle="modal" data-target="#top_zvor_dzvinok">
                    <?=  Yii::t('frontend/buttons', 'backCall'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row top_row00"></div>
    </div>
    <div id="floating">
        <div class="container hidden-xs visible-sm visible-md visible-lg">
            <div class="row menu-search_row">
                <div class="col-sm-6 col-md-6 col-lg-3 md_menu">
                    <nav id="menu" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <div class="navbar-header visible-xs">
                            <span class="menu_icon"><i class="fa fa-bars "></i></span>
                            <?=  Yii::t('frontend', 'SPARE PARTS / ACCESSORIES'); ?>
                        </div>
                        <!-- desktop dropdown menu -->
                        <div class="collapse navbar-collapse" id="desktop_menu_header">
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="menu_icon">
                                            <i class="fa fa-bars "></i>
                                        </span><?=  Yii::t('frontend', 'SPARE PARTS / ACCESSORIES'); ?></a>
                                    <div id="desktop_menu_dropdown-menu" class="dropdown-menu">
                                        <div class="dropdown-inner">
                                            <ul class="list-unstyled">
                                                <?= MenuWidget::widget(['template' => 'top_menu']) ?>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-5 md_search">
                    <?= $this->render('search', []); ?>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-2 header_txt_content">
                    <a href="<?= Url::to(['/wishlist']) ?>" id="wishlist-total" title="ИЗБРАННОЕ">
                        <div class="obrane_icon" id="obrane_icon"></div>
                        <div class="header_text" id="obrane_text">
                            <?=  Yii::t('frontend', 'FAVORITES'); ?>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-2 header_cart_content">
                    <a href="<?= Url::to(['/cart']) ?>" class="" id="cart-total">
                        <div class="obrane_icon cart_icon"></div>
                        <div class="header_text" id="obrane_text">
                            <?=  Yii::t('frontend', 'Cart'); ?>
                            <br>
                            <?php if($session['cart.qty']):?>
                                <span><?=$session['cart.qty'];?> шт. - <?=$session['cart.sum'];?> грн.</span>
                            <?php else:?>
                                <span>0 шт. - 0 грн.</span>
                            <?php endif;?>

                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="container visible-xs">
            <div class="row menu-search_row menu_search_block">
                <div class="col-xs-6 xs_menu">
                    <nav id="menu" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <div class="navbar-header visible-xs">
                            <span class="menu_icon"><i class="fa fa-bars "></i></span><?=  Yii::t('frontend', 'SPARE PARTS / ACCESSORIES'); ?>
                        </div>
                        <!-- mobile dropdown menu -->
                        <div class="collapse navbar-collapse navbar-ex1-collapse" id="mobile_menu_header">
                            <ul class="nav navbar-nav">
                                <?= MenuWidget::widget(['template' => 'top_menu']) ?>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-xs-6 xs_menu">
                    <?= $this->render('search', []); ?>
                </div>
            </div>
            <div class="row menu-search_row">
                <div class="col-xs-6 header_txt_content">
                    <a href="<?= Url::to(['/wishlist']) ?>" id="wishlist-total" title="ИЗБРАННОЕ">
                        <div class="obrane_icon" id="obrane_icon"></div>
                        <div class="header_text" id="obrane_text">
                            <?=  Yii::t('frontend', 'FAVORITES'); ?>
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 header_cart_content" id="cart_xs_div">
                        <a href="<?= Url::to(['/cart']) ?>" class="" id="cart-total">
                            <div class="obrane_icon cart_icon"></div>
                            <div class="header_text" id="obrane_text">
                                <?=  Yii::t('frontend', 'Cart'); ?>
                            </div>
                        </a>
                </div>
            </div>
        </div>
    </div>
</header>



