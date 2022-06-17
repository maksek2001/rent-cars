<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Ассет для аренды
 * @author Spirkov Maksim
 */
class RentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/rent.css',
        'css/scroll.css'
    ];

    public $js = [
        'js/main.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
