<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $news */
/* @var $pages LinkPager */
/* @var $language_id */
/* @var $content_name_id */
/* @var $content_short_content_id */
/* @var $type_blog_id */

$this->title = Yii::t('frontend', 'News');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container news-list">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="col-md-12">
        <div class="row">
            <?php if (isset($news) && !empty($news)): ?>
                <?php for ($x = 0; $x <= count($news); $x++): ?>
                    <?php if (isset($news[$x]) && !empty($news[$x])): ?>
                        <div class="col-sm-12 text-left news">
                            <h1>
                                <?= $news[$x]['name'] ?>
                            </h1>
                            <p>
                                <?= $news[$x]['short_content'] ?>
                            </p>
                            <div class="text-right">
                                <?= Html::a('Перейти',['site/news','slug'=>$news[$x]['slug']]); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="line1_under_pagination"></div>
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'class' => 'pagination'
                ]); ?>
            </div>
        </div>
    </div>
</div>