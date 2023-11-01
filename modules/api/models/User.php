<?php

namespace app\modules\api\models;

use DateTime;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{


    public static function tableName()
    {
        return 'user';
    }

    public static function findByUserId(int $id) {
        return static::find()
            ->where(['id' => $id])
            ->one();
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