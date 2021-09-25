<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_id */

/* @var $this yii\web\View */
/* @var $searchModel backend\models\products\ProductsCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-comments-index">

    <?= $this->render('_search', ['model' => $searchModel, 'language_id' => $language_id, 'content_id' => $content_id, 'type_products_id' => $type_products_id]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'product_id',
                'value' => function ($model) use ($type_products_id, $content_id, $language_id) {
                    $model->product->language_id = $language_id;
                    $model->product->content_id = $content_id;
                    $model->product->type_id = $type_products_id;
                    $name = $model->product->translation->content;
                    return $name;
                },
                'format' => 'html'
            ],
            'name',
            'comment:ntext',
            [
                'attribute' => 'rating',
                'value' => function ($model) {
                    for($x = 1; $x <= 5; $x++) {
                        $str .= '<span class="fa fa-stack">';
                        if ($x <= $model->rating) {
                            $str .= '<i class="fa fa-star fa-stack-2x"></i>';
                        }
                        $str .=' <i class="fa fa-star-o fa-stack-2x"></i></span>';
                    }
                    return $str;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'active',
                'value' => function ($model) {
                    if ($model->active == 1) {
                        return Yii::t('backend/buttons', 'Yes');
                    } elseif ($model->active == 0) {
                        return Yii::t('backend/buttons', 'No');
                    }
                    return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
