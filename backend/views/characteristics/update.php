<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Characteristics */

$name = unserialize($model->name);
$firstKey = current($params);
$this->title = 'Update Characteristics: ' . $name[$firstKey];
$this->params['breadcrumbs'][] = ['label' => 'Characteristics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $name[$firstKey], 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="characteristics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'language' => $language,
    ]) ?>

</div>
