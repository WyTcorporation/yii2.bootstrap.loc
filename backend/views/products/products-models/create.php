<?php

use yii\helpers\Html;

/* @var $params */
/* @var $translation */
/* @var $translations */


/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsModels */

$this->title = Yii::t('backend', 'Create Products Models');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-models-create">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translation' => $translation,
        'translations' => $translations = null,
    ]) ?>

</div>
