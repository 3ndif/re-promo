<?php

namespace common\models\file;

use Yii;

/**
 * This is the model class for table "files_types".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $public
 *
 * @property Files[] $files
 */
class FileType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['public'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'desc' => Yii::t('app', 'Desc'),
            'public' => Yii::t('app', 'Public'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['files_types_id' => 'id']);
    }
}
