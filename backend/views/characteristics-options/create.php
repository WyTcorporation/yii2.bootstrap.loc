<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CharacteristicsOptions */

$this->title = 'Create Characteristics Options';
$this->params['breadcrumbs'][] = ['label' => 'Characteristics Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-options-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'language' => $language,
    ]) ?>

</div>
