<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\callback\CallBack */

$this->title = Yii::t('backend', 'Create Call Back');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Call Backs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-back-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
