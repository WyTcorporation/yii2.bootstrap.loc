<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\orders\Orders */

$this->title = Yii::t('backend', 'Update Orders').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="orders-update">

    <?= $this->render('_form', [
        'model' => $model,
        'OrdersItems' => $OrdersItems,
    ]) ?>

</div>
