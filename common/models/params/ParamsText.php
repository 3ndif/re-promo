<?php

namespace common\models\params;

use Yii;

/**
 * This is the model class for table "params_text".
 *
 * @property integer $id
 * @property integer $params_id
 * @property integer $languages_id
 * @property string $name
 *
 * @property Params $params
 * @property Languages $languages
 */
class ParamsText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'params_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['params_id', 'languages_id', 'name'], 'required'],
            [['params_id', 'languages_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['params_id'], 'exist', 'skipOnError' => true, 'targetClass' => Params::className(), 'targetAttribute' => ['params_id' => 'id']],
            [['languages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['languages_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'params_id' => Yii::t('app', 'Params ID'),
            'languages_id' => Yii::t('app', 'Languages ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParam()
    {
        return $this->hasOne(Params::className(), ['id' => 'params_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'languages_id']);
    }
}
