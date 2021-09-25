<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 11.09.2021
 * Time: 11:50
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $params */
/* @var $orders */

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Orders');

?>

<div class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12" style="margin-bottom: 25px;">
            <?php if (isset($orders) && !empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order">
                        <h3><?=  Yii::t('frontend', 'Order number'); ?> <?= $order->id ?></h3>
                        <p class="text-left"><?=  Yii::t('frontend', 'Quantity'); ?> : <?= $order->qty ?> <?=  Yii::t('frontend', 'Sum'); ?> : <?= $order->sum ?></p>
                        <div class="items">
                            <?php foreach ($order->ordersItems as $item): ?>
                                <div class="item">
                                    <?php
                                    if (count($params) >= 1) {
                                        $name = $item->name;
                                        $img = $item->img;
                                        if ($img == 'no-image.png') {
                                            $img_url = '/images/' . $img;
                                        } else {
                                            $img_url = $img;
                                        }
                                    }
                                    ?>
                                    <?= Html::a(Html::img($img_url, ['alt' => $name]), ['category/view', 'slug' => $item->slug]) ?>
                                    <div class="content">
                                        <h5><?= $name ?></h5>

                                        <h5><?=  Yii::t('frontend', 'Price per piece'); ?> : <?= $item->price ?></h5>

                                        <h5><?= Yii::t('frontend', 'Quantity'); ?> : <?= $item->qty_item ?></h5>

                                        <h5><?= Yii::t('frontend', 'Sum'); ?> : <?= $item->sum_item ?></h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h1><?= Yii::t('frontend', 'No orders!'); ?></h1>
            <?php endif; ?>
        </div>
    </div>
</div>