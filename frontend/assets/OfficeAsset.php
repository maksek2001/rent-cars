<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Ассет для личного кабинета
 * @author Spirkov Maksim
 */
class OfficeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/menu.css',
        'css/main.css',
        'css/office.css',
        'css/scroll.css'
    ];

    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
