<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_models_id */

/* @var $this yii\web\View */
/* @var $searchModel backend\models\products\ProductsModelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Products Models');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-models-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
