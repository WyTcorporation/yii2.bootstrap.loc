<?php

use backend\models\user\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\orders\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
