<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\callback\CallBack */

$this->title = Yii::t('backend', 'Update Call Back').': ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Call Backs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="call-back-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
