<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $domain
 * @property string $techname
 * @property integer $active
 * @property string $meta_google
 * @property string $meta_yandex
 * @property string $longitude
 * @property string $latitude
 *
 * @property CountriesText[] $countriesTexts
 * @property Regions[] $regions
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'techname'], 'required'],
            [['active'], 'integer'],
            [['domain', 'techname', 'meta_google', 'meta_yandex', 'longitude', 'latitude'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'techname' => 'Techname',
            'active' => 'Active',
            'meta_google' => 'Meta Google',
            'meta_yandex' => 'Meta Yandex',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
        ];
    }

    public static function find(){
        return new scopes\CountryQuery(get_called_class());
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'languages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryTexts()
    {
        return $this->hasMany(CountryText::className(), ['countries_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Regions::className(), ['countries_id' => 'id']);
    }
}
