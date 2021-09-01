<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Characteristics */

$this->title = 'Create Characteristics';
$this->params['breadcrumbs'][] = ['label' => 'Characteristics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'language' => $language,
    ]) ?>

</div>
