<?php
namespace frontend\models;

use common\models\Category as ParentCategory;

class Category extends ParentCategory {
    /**
     * Главные категории, которые выводяться на главной странице
     */
    public static function getTopCategories($limit = 5){
        $categories = self::find()
                ->where(['is','parent_id',null])
                ->withI18n()
                ->withIcon();

        if ($limit !== false){
            $categories->limit($limit);
        }

        return $categories->all();
    }
}
