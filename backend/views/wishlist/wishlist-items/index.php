<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\wishlist\WishlistItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wishlist Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishlist-items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Wishlist Items', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'wishlist_id',
            'product_id',
            'name',
            'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'created_ip',
            //'updated_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
