<?php
namespace backend\models;

use yii\helpers\ArrayHelper;
use common\models\Category as CommonCategory;

class Category extends CommonCategory {

    /**
     * Найти всех родителей пункта меню
     */
    public function getAllParentsForBreadcrumbs()
    {
        $parent = $this;
        $breadcrumbs = [];

        while ($parent) {
            $breadcrumbs[] = $parent;

            $parent = $parent->getParent()->one();
        }

        $breadcrumbs = array_reverse($breadcrumbs);

        return ArrayHelper::index($breadcrumbs, 'techname');
    }

    /**
     * Вернуть главные категории категории (без родительских категорий)
     */
    public static function getMainCategories(){
        return Category::find()
                    ->withI18n()
                    ->where(['parent_id' => null])
                    ->all();
    }
}