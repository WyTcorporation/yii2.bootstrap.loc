<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 09.09.2021
 * Time: 12:35
 * User: WyTcorporation
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 text-center" style="margin-bottom: 25px;">
            <h1><?=  Yii::t('frontend/cart', 'thanks'); ?></h1>
            <p><?=  Yii::t('frontend/cart', 'Our manager will contact you shortly'); ?></p>
                <?= html::a(Yii::t('frontend/buttons', 'ContinueShoppingButton'),'/') ?>
        </div>
    </div>
</div>