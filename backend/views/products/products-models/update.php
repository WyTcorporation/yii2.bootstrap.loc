<?php

use yii\helpers\Html;


/* @var $params */
/* @var $translation */
/* @var $translations */
/* @var $language_id */
/* @var $content_id */
/* @var $type_products_models_id */

/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsModels */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_products_models_id;

$this->title = Yii::t('backend', 'Update Products Models').': ' . $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->translation->content, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="products-models-update">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translation' => $translation,
        'translations' => $translations,
    ]) ?>

</div>
