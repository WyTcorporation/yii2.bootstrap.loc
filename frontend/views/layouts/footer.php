<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 16:46
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

use backend\models\pages\Pages;


$params = Yii::$app->params['languages'];

$pages = Pages::find()->where(['active' => 1, 'status' => 1])->all();
$language = \backend\models\translations\Languages::findOne(['code' => Yii::$app->language]);
$language_id = $language->id;
$type_id = \backend\models\translations\Type::findOne(['type' => 'pages']);
$content_id = \backend\models\translations\Content::findOne(['content' => 'name']);

$session = Yii::$app->session;
$contacts = $session['contacts'][0];

$language = Yii::$app->language;

if (count($params) > 1) {
    if ($language != 'ua') {
        $url = '/' . $language . '/cart/view';
    } else {
        $url = '/cart/view';
    }
} else {
    $url = '/cart/view';
}

?>

<footer style="margin-top: 0px;">
    <div id="footer_btn_top"></div>
    <div class="footer_line"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-xs-12 col-sm-3 col-md-3">
                <h5><?= Yii::t('frontend', 'Information'); ?></h5>
                <div class="footer_text_links">
                    <?php if (isset($pages) && !empty($pages)) : ?>
                        <?php foreach ($pages as $page) : ?>
                            <?php
                            $page->language_id = $language_id;
                            $page->type_id = $type_id;
                            $page->content_id = $content_id;
                            $name = $page->translation;
                            ?>
                            <a href="<?= Url::to(['/pages/index', 'slug' => $page->slug]) ?>"><?=$name->content?></a><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 mobi-padding-rigth0">
                <h5><?= Yii::t('frontend', 'Contacts'); ?></h5>
                <div class="footer_text">
                    <?php if (isset($contacts['phones']) && !empty($contacts['phones'])): ?>
                        <?php for ($x=0;$x<=count($contacts['phones']);$x++) :?>
                            <span style="font-family: Tahoma; font-size: 14px;"><?= $contacts['phones'][$x] ?></span>
                            <br style="font-family: Tahoma;">
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3">
                <h5><?= Yii::t('frontend', 'Schedule'); ?></h5>
                <div class="footer_text_shedule">
                    <b style="font-family: Tahoma;">
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
            <div class="col-xs-6 col-sm-3 col-md-3 mobi-padding-rigth0">
                <h5><?= Yii::t('frontend', 'social'); ?></h5>
                <div id="footer_soc_mereji">
                    <a href="<?= Url::to('https://www.facebook.com/') ?>" rel="nofollow noopener" id="footer_facebook"
                       target="_blank"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_line1"></div>
    <div class="container">
        <div class="row footer_powered_div">
            <div class="col-xs-6 col-sm-6 text-left">
                Copyright &copy; <?= Html::encode(Yii::$app->name) ?>  2011-<?= date('Y') ?> <a target="_blank" href="http://lockit.com.ua">LockIT Studio</a>
            </div>
            <div class="col-sm-2 hidden-xs hidden-sm">
                &nbsp;
            </div>
            <div class="col-sm-2 hidden-xs hidden-sm">
                &nbsp;
            </div>
            <div class="col-md-2 text-left hidden-xs hidden-sm">
            </div>
            <div class="col-sm-3 visible-sm">
                &nbsp;
            </div>
            <div class="col-xs-6 col-sm-3 text-left visible-xs visible-sm">
            </div>
        </div>
    </div>
</footer>
<a href="#top" id="scroller" title="Scroll Back to Top"
     style="position: fixed; bottom: 175px; right: 3px; opacity: 1; cursor: pointer;"><img
            src="/images/top-normal.png"
            style="width:53px; height:53px; border:0px solid #DDDDDD;"></a>
<?php
//Модальное окно
Modal::begin([
    'header' => '<h2>'.Yii::t('frontend', 'Basket').'</h2>',
    'id' => 'cart',
//    'toggleButton' => [
//        'label' => 'click me',
//        'tag' => 'button',
//        'class' => 'btn btn-success',
//    ],
    'size' => 'modal-lg',
    'footer' => '<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default">'.Yii::t('frontend/buttons', 'ContinueShoppingButton').'</button>
<button type="button" class="btn btn-danger" onclick="clearCart()">'.Yii::t('frontend/buttons', 'EmptyTrashButton').'</button>
<a href="' . Url::to($url) . '" class="btn btn-success">'.Yii::t('frontend/buttons', 'CheckoutButton').'</a>',
]);

echo 'Say hello...';

Modal::end();
?>

<?php
//Модальное окно
Modal::begin([
    'header' => '<h2>'.Yii::t('frontend', 'wishlist').'</h2>',
    'id' => 'wishlist',
//    'toggleButton' => [
//        'label' => 'click me',
//        'tag' => 'button',
//        'class' => 'btn btn-success',
//    ],
    'size' => 'modal-lg',
    'footer' => '<button  data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-default">'.Yii::t('frontend/buttons', 'ContinueShoppingButton').'</button>',
]);

echo 'Say hello...';

Modal::end();
?>

<?php
//Модальное окно
Modal::begin([
    'header' => '<h2>'.Yii::t('frontend', 'Payment').'</h2>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'payment',
//    'toggleButton' => [
//        'label' => 'click me',
//        'tag' => 'button',
//        'class' => 'btn btn-success',
//    ],
    'size' => 'modal-lg',
    'footer' => '<button type="button" class="btn btn-default close" data-dismiss="modal" aria-label="Close">'.Yii::t('frontend/buttons', 'closeButton').'</button>',
]);

Modal::end();
?>
