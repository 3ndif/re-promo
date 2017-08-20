<?php

namespace common\models\file;

use Yii;

/**
 * This is the model class for table "files_exts".
 *
 * @property integer $id
 * @property string $ext
 * @property string $mime
 * @property integer $attachment
 * @property integer $files_exts_types_id
 *
 * @property Files[] $files
 */
class FileExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files_exts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ext', 'mime', 'attachment', 'files_exts_types_id'], 'required'],
            [['attachment', 'files_exts_types_id'], 'integer'],
            [['ext'], 'string', 'max' => 10],
            [['mime'], 'string', 'max' => 100],
            [['ext'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ext' => Yii::t('app', 'Ext'),
            'mime' => Yii::t('app', 'Mime'),
            'attachment' => Yii::t('app', 'Attachment'),
            'files_exts_types_id' => Yii::t('app', 'Files Exts Types ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['files_exts_id' => 'id']);
    }
}
