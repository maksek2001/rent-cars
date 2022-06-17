<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Основной ассет
 * @author Spirkov Maksim
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/w3.css',
        'css/scroll.css',
        'css/slider.css',
        'css/menu.css',
        'css/main.css',
        'css/animateImage.css'
    ];
    public $js = [
        'js/slider.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
