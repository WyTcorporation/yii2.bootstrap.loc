<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\categories\Categories */
/* @var $language_id */
/* @var $content_id */
/* @var $type_categories_id */
/* @var $type_characteristics_id */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_categories_id;

$this->title = $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="categories-view">
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
            [
                'attribute' => 'percents',
                'value' => function ($model) {
                    if(isset($model->categoriesPercents) && !empty($model->categoriesPercents)) {
                        $array = $model->categoriesPercents;
                        $str = '<div>';
                        for ($x = 0; $x <= count($array); $x++) {
                            if (isset($array[$x]) && !empty($array[$x])) {
                                if ($array[$x]->role == 1) {
                                    $str .= '<div>'.Yii::t('backend', 'Retail').' = '.$array[$x]->content.'% </div>';
                                } elseif ($array[$x]->role== 2) {
                                    $str .= '<div>'.Yii::t('backend', 'Small wholesale').' = '.$array[$x]->content.'% </div>';
                                } elseif ($array[$x]->role == 3) {
                                    $str .= '<div>'.Yii::t('backend', 'Wholesale').' = '.$array[$x]->content.'% </div>';
                                }
                            }
                        }
                        $str .= '</div>';
                        return $str;
                    }
                    return null;
                },
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
