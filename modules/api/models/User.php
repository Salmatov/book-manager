<?php

namespace app\modules\api\models;

use DateTime;
use Exception;
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

    /**
     * @param int $id
     * @return User
     * @throws Exception
     */
    public static function findByUserId(int $id): User
    {
        /** @var User $user */
        $user = static::findOne($id);
        // @TODO как лучше, выдавать exception или возвращать null
        if (!$user) {
            throw new Exception('User not found');
        }
        return $user;
    }


    public static function findAllByUserName(string $userName):array {
        $query = static::find();
        if (!empty($userName)) {
            $query->orWhere(['userName' => $userName]);
        }
        return $query->all();
    }

    public static function findByUserNameAndReturnDate(string $userName, DateTime $returnDate):array {
        $query = static::find();
        if (!empty($userName)) {
            $query->orWhere(['userName' => $userName]);
        }
        if (!empty($userName)&&!empty($returnDate)) {
            $query->andWhere(['returnDate' => $returnDate]);
        }elseif (!empty($returnDate)) {
            $query->orWhere(['returnDate' => $returnDate]);
        }
        return $query->all();
    }

    public static function getUserListByNameAndReturnDate(string $userName, $returnDate, $pageNumber, $pageSize) {
        $query = static::find();
    }
}