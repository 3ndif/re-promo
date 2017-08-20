<?php
namespace common\models\scopes;

use yii\db\ActiveQuery;

class FileQuery extends ActiveQuery {

    /**
     * Расширения файла
     */
    public function withExt(){
        return $this->with('fileExt');
    }
}