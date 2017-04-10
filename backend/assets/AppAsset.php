<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public static function addCssFile($view, $file)
    {
        foreach ($file as $value) {
            $view->registerCssFile($value, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
        }
    }

    public static function addJsFile($view, $file)
    {
        foreach ($file as $value) {
            $view->registerJsFile($value, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
        }
    }
}
