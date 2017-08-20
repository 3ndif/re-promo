<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://unpkg.com/react@15/dist/react.min.js"></script>
    <script src="https://unpkg.com/react-dom@15/dist/react-dom.min.js"></script>
    <?php $this->head() ?>
    <?= frontend\widgets\AssetsList::widget(['alias'=>'frontend'])?>
</head>
<body>
<?php $this->beginBody(); ?>

<div class="wrap">
    <div class="container">
        <div class="row">
            <div id="left_sidebar" class="col-md-2">
                <div class="logo">
                    <a href="/"><img src="/img/czsale-logo.png"></a>
                </div>
            </div>
            <div class="col-md-8" role="main">

                <div id="top_filter_box">
                    <?php
                        echo $this->render(
                            'top-main-services'
                        );
                    ?>
                </div>

                <!--<div class="well"></div>-->
                <div id="alert-container"></div>
                <div id="content"><?= $content ?></div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
