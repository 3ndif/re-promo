<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UsersHasIds[] $usersHasIds
 */
class User extends \common\models\User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersHasIds()
    {
        return $this->hasMany(UsersHasIds::className(), ['users_id' => 'id']);
    }
}
