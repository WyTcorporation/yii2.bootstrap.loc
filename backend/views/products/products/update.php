<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\products\Products */
/* @var $params  */
/* @var $language  */
/* @var $language_id  */
/* @var $type_products_id  */
/* @var $productsModelsTypeId  */
/* @var $categoriesTypeId  */
/* @var $characteristicsTypeId  */
/* @var $content_id  */
/* @var $translation  */
/* @var $productsModels  */
/* @var $characteristicsOptionsTypeId  */
/* @var $translations  */
/* @var $optionArray  */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_products_id;

$this->title = Yii::t('backend', 'Update Products').': ' . $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->translation->content, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="products-update">
    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'language_id' => $language_id,
        'productsModelsTypeId' => $productsModelsTypeId,
        'categoriesTypeId' => $categoriesTypeId,
        'characteristicsTypeId' => $characteristicsTypeId,
        'characteristicsOptionsTypeId' => $characteristicsOptionsTypeId,
        'content_id' => $content_id,
        'translation' => $translation,
        'translations' => $translations,
        'optionArray' => $optionArray,
    ]) ?>

</div>
