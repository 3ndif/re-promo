<?php
namespace common\models;

use Yii;

class Img extends \yii\base\Model {

    const COMMON  = 'img';
    const ICON = 'img/icons';

    public $imageFile;

    public function rules(){

        return [
            [['imageFile'], 'file',  'extensions' => 'png,jpg,jpeg'],
        ];
    }

    public static function getPath($dir = self::COMMON, $img = null){
        $dir = \Yii::getAlias("@web/$dir");

        return is_null($img) ? "$dir" : "$dir/$img";
    }

    public static function getIconDir(){
        $dir = \Yii::getAlias('@app/web/'.self::ICON);
        return $dir;
    }

    public function upload($dir = self::COMMON)
    {
        $dir = Yii::getAlias("@app/web/$dir");

        if ($this->validate()) {
            $rnd = rand(0,99999999999);  // generate random number between 0-9999
            $fileName = "{$rnd}-{$this->imageFile->baseName}";
            $this->imageFile->name = $fileName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs("$dir/" . $this->imageFile->name);
            return true;
        } else {
            return false;
        }
    }
}