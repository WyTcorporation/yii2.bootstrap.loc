<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\orders\Orders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <p>
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->user->username ? $model->user->username : '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            'name',
            'email:email',
            'phone',
            [
                'attribute' => 'address',
                'value' => function ($model) {
                    if (isset($model->address) && !empty($model->address)) {
                        return $model->address;
                    } elseif (isset($model->user) && !empty($model->user)) {
                        $addresses = $model->user->userAddresses[0];
                        return Yii::t('backend', 'Company') . ': ' . $addresses->company . ', ' . Yii::t('backend', 'City') . ': ' . $addresses->city . ', ' . Yii::t('backend', 'Address1') . ': ' . $addresses->address_1 . ', ' . Yii::t('backend', 'Address2') . ': ' . $addresses->address_2;
                    }
                    return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            'qty',
            'sum',
            [
                'attribute' => 'payment',
                'value' => function ($model) {
                    if ($model->payment == 1) {
                        return Yii::t('backend', 'Card account');
                    } elseif ($model->payment == 2) {
                        return Yii::t('backend', 'Payment upon receipt (New Mail)');
                    } elseif ($model->payment == 3) {
                        return Yii::t('backend', 'Payment1');
                    } elseif ($model->payment == 4) {
                        return Yii::t('backend', 'Payment2');
                    }
                    return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'shipping',
                'value' => function ($model) {
                    if ($model->shipping == 1) {
                        return Yii::t('backend', 'Pickup from the store');
                    } elseif ($model->shipping == 2) {
                        return Yii::t('backend', 'New mail');
                    }
                    return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == 1) {
                        return Yii::t('backend/buttons', 'Yes');
                    } elseif ($model->status == 0) {
                        return Yii::t('backend/buttons', 'No');
                    }
                    return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],

        ],
    ]) ?>
    <?php if (isset($model->ordersItems) && !empty($model->ordersItems)): ?>
    <h3><?=  Yii::t('backend', 'Products') ?></h3>
        <?php $ordersItems = $model->ordersItems; ?>
        <?php for ($x = 0; $x <= count($ordersItems); $x++) : ?>
            <?php if (isset($ordersItems[$x]) && !empty($ordersItems[$x])): ?>
                <div class="col-md-6">
                    <div class="col-md-3">
                        <?= Html::a(Html::img($ordersItems[$x]->img == 'no-image.png' ? '/images/no-image.png' : $ordersItems[$x]->img,
                            [
                                'alt' => $ordersItems[$x]->name,
                                'width' => '135px'
                            ]
                        ), [
                            'products/products/view', 'id' => $ordersItems[$x]->product_id
                        ]); ?>
                    </div>
                    <div class="col-md-9">
                        <p><?=  Yii::t('backend', 'Name') ?>: <?= $ordersItems[$x]->name ?></p>
                        <p><?=  Yii::t('backend/attributes', 'Price') ?>: <?= $ordersItems[$x]->price ?></p>
                        <p><?=  Yii::t('backend/attributes', 'Quantity') ?>: <?= $ordersItems[$x]->qty_item ?></p>
                        <p><?=  Yii::t('backend/attributes', 'Sum') ?>: <?= $ordersItems[$x]->sum_item ?></p>
                    </div>
                </div>

            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
    <div class="clearfix"></div>
</div>
