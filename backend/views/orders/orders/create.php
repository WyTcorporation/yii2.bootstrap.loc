<?php

use yii\helpers\Html;

/* @var $OrdersItems */
/* @var $this yii\web\View */
/* @var $model backend\models\orders\Orders */

$this->title = Yii::t('backend', 'Create Orders');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <?= $this->render('_form', [
        'model' => $model,
        'OrdersItems' => $OrdersItems,
    ]) ?>

</div>
