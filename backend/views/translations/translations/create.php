<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\translations\Translations */

$this->title = 'Create Translations';
$this->params['breadcrumbs'][] = ['label' => 'Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
