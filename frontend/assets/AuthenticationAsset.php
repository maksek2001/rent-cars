<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Ассет для авторизации и регистрации
 * @author Spirkov Maksim
 */
class AuthenticationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/scroll.css'
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
