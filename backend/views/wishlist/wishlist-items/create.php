<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\wishlist\WishlistItems */

$this->title = 'Create Wishlist Items';
$this->params['breadcrumbs'][] = ['label' => 'Wishlist Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishlist-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
