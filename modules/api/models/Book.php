<?php

namespace app\modules\api\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{


    public static function tableName()
    {
        return 'book';
    }

    public static function findByBookId(int $bookId)
    {
        return static::find()
            ->where(['id' => $bookId])
            ->one();
    }

    public static function findByBookNickname(string $nickname){
        return static::find()
            ->where(['nickName' => $nickname])
            ->one();
    }
}
