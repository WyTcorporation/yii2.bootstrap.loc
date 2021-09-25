<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 02.09.2021
 * Time: 08:23
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\helpers\Url;

$params = Yii::$app->params['languages'];

use backend\models\pages\Pages;

$pages = Pages::find()->where(['active' => 1, 'status' => 1])->all();
$language = \backend\models\translations\Languages::findOne(['code' => Yii::$app->language]);
$language_id = $language->id;
$type_id = \backend\models\translations\Type::findOne(['type' => 'pages']);
$content_id = \backend\models\translations\Content::findOne(['content' => 'name']);

?>
<div class="container">
    <div class="top_content1">
        <div class="pull-right">
            <div class="btn-group">
                <div class="main_dropdown_in_top1">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <a href="<?= Url::to(['/login']) ?>">
                            <img src="/images/enter.png.pagespeed.ce.JEYtUk9R69.png" alt="<?=  Yii::t('frontend/links', 'Login'); ?>">
                            <?=  Yii::t('frontend/links', 'Login'); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?= Url::to(['/profile']) ?>">
                            <img src="/images/enter.png.pagespeed.ce.JEYtUk9R69.png" alt="<?=  Yii::t('frontend/links', 'Profile'); ?>">
                            <?=  Yii::t('frontend/links', 'Profile'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (count($params) > 1) : ?>
            <div class="pull-right" style="margin-right: 17px;">
                <div class="btn-group"
                     onmouseover="document.getElementById('languages-dropdown_ul').style.display = 'block';"
                     onmouseout="document.getElementById('languages-dropdown_ul').style.display = 'none';">
                    <div class="main_dropdown_in_top" data-toggle="dropdown">
                        <img src="/images/lang.png.pagespeed.ce.ME-EsYZZdm.png" alt="<?= Yii::$app->language; ?>"
                             title="<?= Yii::$app->language; ?>">
                        <?= strtoupper(Yii::$app->language); ?>
                    </div>
                    <div id="form-language">
                        <ul id="languages-dropdown_ul" class="dropdown-menu pull-right"
                            style="min-width: auto; margin: 0; padding: 0;">
                            <?= common\modules\languages\widgets\ListWidget::widget() ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="pull-left" id="header_mobile_btn">
            <i class="fa fa-bars "></i>
        </div>
        <div id="top-links" class="nav pull-left">
            <ul class="list-inline">
                <li><a href="<?= Url::to(['/']) ?>"><?=  Yii::t('frontend/links', 'Home'); ?></a></li>
                <?php if (isset($pages) && !empty($pages)) : ?>
                    <?php foreach ($pages as $page) : ?>
                        <?php
                        $page->language_id = $language_id;
                        $page->type_id = $type_id;
                        $page->content_id = $content_id;
                        $name = $page->translation->content;
                        ?>
                        <li><a href="<?= Url::to(['/pages/index', 'slug' => $page->slug]) ?>"><?= $name ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <li><a href="<?= Url::to(['site/index']) ?>"><?=  Yii::t('frontend/links', 'News'); ?></a></li>
                <li><a href="<?= Url::to(['product/new']) ?>"><?=  Yii::t('frontend/links', 'New'); ?></a></li>
                <li><a href="<?= Url::to(['product/sale']) ?>"><?=  Yii::t('frontend/links', 'Sale'); ?></a></li>
                <li><a href="<?= Url::to(['site/contact']) ?>"><?=  Yii::t('frontend/links', 'Contacts'); ?></a></li>
            </ul>
        </div>
    </div>
</div>
