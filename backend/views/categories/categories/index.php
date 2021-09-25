<?php

use backend\models\translations\Languages;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_categories_id */
/* @var $type_characteristics_id */
/* @var $this yii\web\View */
/* @var $searchModel backend\models\categories\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="categories-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'parent_id',
                'value' => function ($model) use ($type_categories_id, $language_id, $content_id) {
                    if (isset($model->parent_id) && !empty($model->parent_id) && $model->parent_id != 0) {
                        $model->category->language_id = $language_id;
                        $model->category->content_id = $content_id;
                        $model->category->type_id = $type_categories_id;
                        return '<span class="text-success">' . $model->category->translation->content . '</span>';
                    } else {
                        return '<span class="text-danger">' . Yii::t('backend', 'Main') . '</span>';
                    }
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'name',
                'value' => function ($model) use ($type_categories_id, $language_id, $content_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_categories_id;
                    return $model->translation->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'characteristics',
                'value' => function ($model) use ($type_characteristics_id, $language_id, $content_id) {
                    if (isset($model->categoriesCharacteristics) && !empty($model->categoriesCharacteristics)) {
                        $array = $model->categoriesCharacteristics;
                        $str = '<div>';
                        for ($x = 0; $x <= count($array); $x++) {
                            if (isset($array[$x]) && !empty($array[$x])) {
                                $array[$x]->characteristics->language_id = $language_id;
                                $array[$x]->characteristics->content_id = $content_id;
                                $array[$x]->characteristics->type_id = $type_characteristics_id;
                                $str .= '<div>'.$array[$x]->characteristics->translation->content.'</div>';
                            }
                        }
                        $str .= '</div>';
                        return $str;

                    } else {
                        return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                    }
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'img',
                'value' => function ($model) {
                    return Html::img($model->img == 'no-image.png' ? '/images/no-image.png' : $model->img, ['width' => 135]);
                },
                'format' => 'html'
            ],
            'slug',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
