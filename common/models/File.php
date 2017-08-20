<?php

namespace common\models;

use Yii;
use common\models\file\FileType;
use common\models\file\FileExt;
use common\models\User;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $users_id
 * @property integer $files_exts_id
 * @property integer $files_types_id
 * @property string $name
 * @property integer $public
 * @property integer $is_deleted
 * @property integer $width
 * @property integer $height
 * @property string $download_link
 *
 * @property FilesTypes $filesTypes
 * @property Users $users
 * @property FilesExts $filesExts
 */
class File extends \yii\db\ActiveRecord
{
    const DIR_DEFAULT_IMG = 'img';
    const DIR_ICON = 'img/icons';

    const ICON_DEFAULT = 'pet.png';

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'files_exts_id', 'files_types_id'], 'required'],
            [['users_id', 'files_exts_id', 'files_types_id', 'public', 'is_deleted', 'width', 'height'], 'integer'],
            [['name', 'download_link'], 'string', 'max' => 255],
            [['files_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => FileType::className(), 'targetAttribute' => ['files_types_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['users_id' => 'id']],
            [['files_exts_id'], 'exist', 'skipOnError' => true, 'targetClass' => FileExt::className(), 'targetAttribute' => ['files_exts_id' => 'id']],

            [['created_at', 'updated_at'], 'integer'],

            ['imageFile','image', 'extensions' => 'jpg, gif, png', 'maxWidth' => 250,'maxHeight' => 250],
            ['imageFile', 'extExist']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'users_id' => Yii::t('app', 'Users ID'),
            'files_exts_id' => Yii::t('app', 'Files Exts ID'),
            'files_types_id' => Yii::t('app', 'Files Types ID'),
            'name' => Yii::t('app', 'Name'),
            'public' => Yii::t('app', 'Public'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'download_link' => Yii::t('app', 'Download Link'),
            'created_at' => Yii::t('app', 'Create date'),
            'updated_at' => Yii::t('app', 'Update date'),
        ];
    }

    public static function find(){
        return new scopes\FileQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileType()
    {
        return $this->hasOne(FileType::className(), ['id' => 'files_types_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileExt()
    {
        return $this->hasOne(FileExt::className(), ['id' => 'files_exts_id']);
    }

    public function getFullPath($path){
        return $path . '/' . $this->getFilename();
    }

    public function getPath ($type = self::DIR_DEFAULT_IMG){
        return Yii::getAlias('@app/web/'.$type);
    }

    public function getFileSize($fileDir){
        $filename = $this->getFullPath($fileDir);

        if (!file_exists($filename)) {
            return false;
        }

        $size = filesize($filename);

        return $size;
    }

    public function getFilename($ext = true){
        $extension = '';

        if ($ext){
            if (!$this->fileExt){
                $fileExt = $this->getFileExt()->one();
            } else {
                $fileExt = $this->fileExt;
            }

            $fileExt = $fileExt;
            $extension = '.'.$fileExt->ext;
        }

        return $this->name.$extension;
    }

    public function getMimeType(){

        if (!$this->fileExt){
            $fileExt = $this->getFileExt()->one();
        } else {
            $fileExt = $this->fileExt;
        }

        return $fileExt->mime;
    }

    public function uploadFileAndSave($type = self::DIR_ICON){
            $fileExt = $this->imageFile->extension;
            $fileMime = $this->imageFile->type;

            $ext = FileExt::find()
                ->where(['ext' => $fileExt])
                ->andWhere(['mime' => $fileMime])
                ->one();

            $dir = $this->getPath($type);
            $rnd = rand(0,99999999999);  // generate random number between 0-9999
            $filename = "{$rnd}-{$this->imageFile->baseName}";
            $this->imageFile->name = $filename . '.' . $this->imageFile->extension;

            $this->users_id = Yii::$app->user->id;
            $this->files_exts_id = $ext->id;
            $this->files_types_id = 3;
            $this->name = $filename;

            if ($this->validate()){
            /*
             * Save object to db and file directory system
             */
                $this->save();
                $this->imageFile->saveAs("$dir/" . $this->imageFile->name);
            }

            return $this;
    }

    /**
     * Проверяем существование данного расширения и mime_type в базе данных
     */
    public function extExist($attribute,$params){
        $fileExt = $this->imageFile->extension;
        $fileMime = $this->imageFile->type;

        $ext = FileExt::find()
                ->where(['ext' => $fileExt])
                ->andWhere(['mime' => $fileMime])
                ->one();

        if (!$ext){
            $this->addError("Расширение $ext($fileMime) отсутствует");
        }
    }

    /**
     * ICON default
     */
    public function getFileDefault($filename = self::ICON_DEFAULT){
        return $filename;
    }

}
