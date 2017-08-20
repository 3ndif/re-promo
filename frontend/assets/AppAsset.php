<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fontawesome/css/font-awesome.min.css',
        'dist/main.css',
//        'dropzone/dropzone.css'
    ];
    public $js = [
        'dropzone/dropzone.js',
        'js/dropzone-create-gallery.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\CommonAsset',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $publishOptions = [
        'forceCopy'=>true,
      ];

}
