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
//        'js/dropzone/min/dropzone.min.css',
        'js/dropzone/basic.css',
        'dist/main.css'
    ];

    public $js = [
//        'js/dropzone/min/dropzone.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\CommonAsset',
    ];

    public $sourcePath = '@common/web';

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $publishOptions = [
        'forceCopy'=>true,
      ];
}
