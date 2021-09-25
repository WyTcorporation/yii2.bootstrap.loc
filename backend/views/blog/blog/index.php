<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_blog_id */

/* @var $this yii\web\View */
/* @var $searchModel backend\models\blog\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Blogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'value' => function ($model) use ($type_blog_id, $language_id, $content_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_blog_id;
                    return $model->translation->content;
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
