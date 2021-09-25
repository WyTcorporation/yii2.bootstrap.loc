<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_models_id */

/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsModels */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_products_models_id;

$this->title = $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-models-view">

    <p>
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'active',
                'filter' => [Yii::t('backend', 'Not published'),Yii::t('backend', 'Published')],
                'value' => function ($model)  {
                    return $model->active == 1 ? '<span class="text-success">'.Yii::t('backend', 'Published').'</span>' : '<span class="text-danger">'.Yii::t('backend', 'Not published').'</span>';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'name',
                'value' => function ($model) use ($type_products_models_id, $language_id, $content_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_products_models_id;
                    return $model->translation->content;
                },
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
