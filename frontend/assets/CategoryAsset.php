<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CategoryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i,900&subset=cyrillic',
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/swiper.min.css',
        'css/slick.css',
        'css/articles.css',
        'css/css(1).css',
        'css/css.css',
        'css/style.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.scrollUp.min.js',
        'js/slick.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
