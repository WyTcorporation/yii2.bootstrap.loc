<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $language */
/* @var $content */


/* @var $this yii\web\View */
/* @var $model backend\models\blog\Blog */



$this->title = $content[$language]['name']->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

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
                'value' => function ($model) use ($language, $content) {
                    return $content[$language]['name']->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'short_content',
                'value' => function ($model) use ($language, $content) {
                    return $content[$language]['short_content']->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'content',
                'value' => function ($model) use ($language, $content) {
                    return $content[$language]['content']->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'keywords',
                'value' => function ($model) use ($language, $content) {
                    return $content[$language]['keywords']->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'description',
                'value' => function ($model) use ($language, $content) {
                    return $content[$language]['description']->content;
                },
                'format' => 'html'
            ],
            'slug',
            [
                'attribute' => 'active',
                'value' => function ($data) {
                    if ($data->active == 1) {
                        $action = '<span class="text-success">'.Yii::t('backend/buttons', 'Published').'</span>';
                    } else {
                        $action = '<span class="text-danger">'.Yii::t('backend/buttons', 'Not published').'</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
