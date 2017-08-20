<?php
namespace common\models\scopes\traits;

trait I18n {

    /**
     * Категория с текущим переводом
     */
    public function withI18n($languages_id = null){
        $textRelationName = self::TEXT_RELATION;
        $textTable = self::TEXT_RELATION_TABLE;

        return $this->with([$textRelationName => function($query) use ($languages_id, $textTable){
            $tableName = $textTable;

            $languages_id = $languages_id ? $languages_id : \Yii::$app->location->language->id;

            return $query->andWhere(["$tableName.languages_id" => $languages_id]);
        }]);
    }
}