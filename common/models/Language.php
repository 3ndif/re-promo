<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $techname
 * @property string $code
 * @property integer $active
 * @property integer $is_default
 *
 * @property CategoriesText[] $categoriesTexts
 * @property CitiesText[] $citiesTexts
 * @property CountriesText[] $countriesTexts
 * @property LanguagesText[] $languagesTexts
 * @property RegionsText[] $regionsTexts
 */
class Language extends \yii\db\ActiveRecord
{

    public static $_allLanguages = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['techname', 'code'], 'required'],
            [['active', 'is_default'], 'integer'],
            [['techname', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'techname' => Yii::t('app', 'Techname'),
            'code' => Yii::t('app', 'Code'),
            'active' => Yii::t('app', 'Active'),
            'is_default' => Yii::t('app', 'Is Default'),
        ];
    }

    public static function find(){
        return new scopes\LanguageQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesTexts()
    {
        return $this->hasMany(CategoriesText::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitiesTexts()
    {
        return $this->hasMany(CitiesText::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountriesTexts()
    {
        return $this->hasMany(CountriesText::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguagesTexts()
    {
        return $this->hasMany(LanguagesText::className(), ['languages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionsTexts()
    {
        return $this->hasMany(RegionsText::className(), ['languages_id' => 'id']);
    }

    public static function getAllLanguages($onlyactive = false){
        if (!self::$_allLanguages){
            self::$_allLanguages = self::find();

            if ($onlyactive) {
                self::$_allLanguages->andWhere(['active' => true]);
            }

            self::$_allLanguages = self::$_allLanguages->all();
        }

        return self::$_allLanguages;
    }
}
