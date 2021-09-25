<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\products\Products */
/* @var $params  */
/* @var $language  */
/* @var $language_id  */
/* @var $productsModelsTypeId  */
/* @var $categoriesTypeId  */
/* @var $characteristicsTypeId  */
/* @var $content_id  */
/* @var $translation  */
/* @var $productsModels  */
/* @var $characteristicsOptionsTypeId  */
/* @var $translations  */
/* @var $optionArray  */

$this->title = Yii::t('backend', 'Create Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'language_id' => $language_id,
        'productsModelsTypeId' => $productsModelsTypeId,
        'categoriesTypeId' => $categoriesTypeId,
        'characteristicsTypeId' => $characteristicsTypeId,
        'content_id' => $content_id,
        'translation' => $translation,
        'characteristicsOptionsTypeId' => $characteristicsOptionsTypeId,
        'optionArray' => $optionArray,
        'translations' => $translations,
    ]) ?>

</div>
