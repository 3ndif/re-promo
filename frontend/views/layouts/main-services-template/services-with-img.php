<?php
use yii\helpers\Html;
?>
<ul class="nav nav-tabs text-center">
    <?php foreach(frontend\models\Category::getTopCategories() as $category) {
        $dir = common\models\Img::ICON;
    ?>
    <li>
        <a href="">
            <?php echo Html::img($category->getIconUrl()) ?>
            <div><?php echo $category->i18n->name?></div>
        </a>
    </li>
    <?php } ?>
</ul>