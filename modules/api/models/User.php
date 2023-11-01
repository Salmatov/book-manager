<?php

namespace app\modules\api\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $firstName
 * @property string $lastName
 * @property $registrationDate
 */
class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return parent::rules();
    }

    public function getLogs(): ActiveQuery
    {
        return $this->hasMany(LibraryLog::class, ['userId' => 'id']);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public static function findById(int $id): ?User
    {
        return static::findOne($id);
    }
}