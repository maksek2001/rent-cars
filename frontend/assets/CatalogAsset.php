<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Ассет для каталога
 * @author Spirkov Maksim
 */
class CatalogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/menu.css',
        'css/catalog.css',
        'css/scroll.css'
    ];

    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
