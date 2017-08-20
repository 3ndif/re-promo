<?php
namespace common\models\scopes;

use yii\db\ActiveQuery;

class ParamsQuery extends ActiveQuery {

    use \common\models\scopes\traits\I18n;

    const TEXT_RELATION = 'paramsText';
    const TEXT_RELATION_TABLE = 'params_text';
}