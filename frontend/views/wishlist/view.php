<?php
/**
 * name: Vladyslav Gladyr
 * email: wild.savedo@gmail.com
 * site: lockit.com
 * 13.07.2020
 */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\components\MenuWidget;
use yii\widgets\Breadcrumbs;

/* @var $wishlist */
/* @var $language_id */
/* @var $content_id */
/* @var $type_id */

$this->title = Yii::t('frontend', 'wishlist');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Personal Area'), 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title ;

?>

<div id="account-wishlist" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-9">
            <h2><?= Yii::t('frontend', 'FAVORITES') ?></h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td class="text-center"><?= Yii::t('frontend', 'Image') ?></td>
                        <td class="text-center"><?= Yii::t('frontend', 'Product code') ?></td>
                        <td class="text-left"><?= Yii::t('frontend', 'Product Name') ?></td>
                        <td class="text-center"><?= Yii::t('frontend', 'Quality') ?></td>
                        <td class="text-right"><?= Yii::t('frontend', 'Availability') ?></td>
                        <td class="text-right"><?= Yii::t('frontend', 'Unit price') ?></td>
                        <td class="text-right"><?= Yii::t('frontend', 'Action') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($wishlist) && !empty($wishlist)) : ?>
                        <?php if (isset($wishlist->wishlistItems) && !empty($wishlist->wishlistItems)) : ?>
                            <?php foreach ($wishlist->wishlistItems as $wishlistItem): ?>

                                <?php
                                $product = $wishlistItem->product;
                                $product->type_id = $type_id;
                                $product->language_id = $language_id;
                                $product->content_id = $content_id;
                                $name = $product->translation->content;

                                ?>
                                    <td class="text-center">
                                        <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                            <?= Html::img( $product->img, ['alt' => $name,'width'=>'100']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?= $product->vendor_code ?></td>
                                    <td class="text-left">
                                        <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                            <?= $name ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $object = null;
                                        $allObject = null;
                                        if (isset($product->product->characteristicsProducts) && !empty($product->product->characteristicsProducts)) {
                                            for ($i = 0; $i <= count($product->product->characteristicsProducts); $i++) {
                                                if ($product->product->characteristicsProducts[$i]->characteristics_options_id == 83) {
                                                    $object = $product->product->characteristicsProducts[$i];
                                                }
                                                $allObject = $product->product->characteristicsProducts[$i];
                                            }
                                        }
                                        if (isset($object) && !empty($object)) {
                                            $col = unserialize($object->characteristicsOptions->name)[$language];
                                        } else {
                                            $col = 'Не указано';
                                        }
                                        echo $col;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php if ($product->status_stock == 0): ?>
                                            <?= Yii::t('frontend/buttons', 'Not available') ?>
                                        <?php elseif ($product->status_stock == 1) : ?>
                                            <?= Yii::t('frontend/buttons', 'In stock') ?>
                                        <?php elseif ($product->status_stock == 2) : ?>
                                            <?= Yii::t('frontend/buttons', 'Expected') ?>
                                        <?php elseif ($product->status_stock == 3) : ?>
                                            <?= Yii::t('frontend/buttons', 'Under the order') ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="price">
                                            <b><?= $product->price ?> грн.</b>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <a href="<?= Url::to(['cart/add', 'id' => $product->id]) ?>"
                                           data-id="<?= $product->id ?>" class="btn btn-primary add-to-cart">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-danger del-item"  href="<?= Url::to(['wishlist/delete-item', 'id' => $product->id]) ?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <h3><?= Yii::t('frontend', 'Wishlist is empty') ?></h3>
                        <?php endif; ?>
                    <?php else : ?>
                        <h3><?= Yii::t('frontend', 'Wishlist is empty') ?></h3>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
            <div class="buttons clearfix">
                <div class="pull-right">
                    <?= Html::a(Yii::t('frontend/buttons', 'proceedButton'), ['profile/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
