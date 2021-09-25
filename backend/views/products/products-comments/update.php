<?php

use yii\helpers\Html;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_id */

/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsComments */

$this->title = Yii::t('backend', 'Update Products Comments').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="products-comments-update">

    <?= $this->render('_form', [
        'model' => $model,
        'language_id' => $language_id,
        'content_id' => $content_id,
        'type_products_id' => $type_products_id,
    ]) ?>

</div>
