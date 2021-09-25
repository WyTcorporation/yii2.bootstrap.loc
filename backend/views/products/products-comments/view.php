<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_products_id */

/* @var $this yii\web\View */
/* @var $model backend\models\products\ProductsComments */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-comments-view">

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
                        if ($model->rating >= $x) {
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
        ],
    ]) ?>

</div>
