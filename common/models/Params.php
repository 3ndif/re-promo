<?php

namespace common\models;

use Yii;
use common\models\params\ParamsText;

/**
 * This is the model class for table "params".
 *
 * @property integer $id
 * @property integer $categories_id
 * @property string $techname
 * @property integer $order
 * @property integer $active
 * @property integer $required
 *
 * @property AdditionalParamsGroups[] $additionalParamsGroups
 * @property AdsParamsValue[] $adsParamsValues
 * @property Categories $categories
 * @property ParamsText[] $paramsTexts
 * @property ParamsValues[] $paramsValues
 */
class Params extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categories_id', 'order', 'active', 'required'], 'integer'],
            [['techname'], 'required'],
            [['techname'], 'string', 'max' => 255],
            [['categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['categories_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'categories_id' => Yii::t('app', 'Categories ID'),
            'techname' => Yii::t('app', 'Techname'),
            'order' => Yii::t('app', 'Order'),
            'active' => Yii::t('app', 'Active'),
            'required' => Yii::t('app', 'Required'),
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => \common\behaviors\I18n::className(),
                'relationName' => 'paramsText',
                'relationClassName' => ParamsText::className(),
            ],
        ];
    }

    public static function find(){
        return new scopes\ParamsQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalParamsGroups()
    {
        return $this->hasMany(AdditionalParamsGroups::className(), ['params_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdsParamsValues()
    {
        return $this->hasMany(AdsParamsValue::className(), ['params_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'categories_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParamsTexts()
    {
        return $this->hasMany(ParamsText::className(), ['params_id' => 'id']);
    }

    public function getParamsText()
    {
        return $this->hasOne(ParamsText::className(), ['params_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParamsValues()
    {
        return $this->hasMany(ParamsValues::className(), ['params_id' => 'id']);
    }
}
