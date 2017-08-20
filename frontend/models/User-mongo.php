<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for collection "User".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $email
 * @property mixed $name
 * @property mixed $password
 */
class User extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['dbtest', 'users'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'email',
            'name',
            'password',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
        ];
    }
}
