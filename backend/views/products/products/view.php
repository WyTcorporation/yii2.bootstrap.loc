<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_id */
/* @var $type_categories_id */
/* @var $type_products_models_id */

/* @var $this yii\web\View */
/* @var $model backend\models\products\Products */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_products_id;

$this->title = $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-view">
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
                'attribute' => 'name',
                'value' => function ($model) use ($type_products_id, $language_id, $content_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_products_id;
                    return $model->translation->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) use ($type_categories_id, $language_id, $content_id) {
                    $model->category->language_id = $language_id;
                    $model->category->content_id = $content_id;
                    $model->category->type_id = $type_categories_id;
                    return $model->category->translation->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'models_id',
                'value' => function ($model) use ($type_products_models_id, $language_id, $content_id) {
                    if (isset($model->model) && !empty($model->model)) {
                        $model->model->language_id = $language_id;
                        $model->model->content_id = $content_id;
                        $model->model->type_id = $type_products_models_id;
                        return $model->model->translation->content;
                    } else {
                        return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                    }
                },
                'format' => 'html'
            ],
            'price',
            [
                'attribute' => 'img',
                'value' => function ($model) {
                    return Html::img($model->img == 'no-image.png' ? '/images/no-image.png' : $model->img, ['width' => 135]);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'vendor_code',
                'value' => function ($model) {
                    return $model->vendor_code;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'hit',
                'value' => function ($data) {
                    if ($data->hit == 1) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'Active') . '</span>';
                    } else {
                        $action = '<span class="text-danger">' . Yii::t('backend/buttons', 'Not Active') . '</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'new',
                'value' => function ($data) {
                    if ($data->new == 1) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'Active') . '</span>';
                    } else {
                        $action = '<span class="text-danger">' . Yii::t('backend/buttons', 'Not Active') . '</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'sale',
                'value' => function ($data) {
                    if ($data->new == 1) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'Active') . '</span>';
                    } else {
                        $action = '<span class="text-danger">' . Yii::t('backend/buttons', 'Not Active') . '</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'active',
                'value' => function ($data) {
                    if ($data->active == 1) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'Active') . '</span>';
                    } else {
                        $action = '<span class="text-danger">' . Yii::t('backend/buttons', 'Not Active') . '</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'status_stock',
                'value' => function ($data) {
                    if ($data->status_stock == 1) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'In stock') . '</span>';
                    } elseif ($data->status_stock == 2) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'Expected') . '</span>';
                    } elseif ($data->status_stock == 3) {
                        $action = '<span class="text-success">' . Yii::t('backend/buttons', 'Under the order') . '</span>';
                    } else {
                        $action = '<span class="text-danger">' . Yii::t('backend/buttons', 'Not available') . '</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],
            'slug',
//            'currency_code',
//            'created_at',
//            'updated_at',
//            'created_ip',
//            'updated_ip',
//            'created_by',
//            'updated_by',

        ],
    ]) ?>

</div>
