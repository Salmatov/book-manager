<?php

namespace app\modules\api\models;

use Exception;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string author
 * @property string bookName
 * @property string nickName
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'book';
    }

    public static function findByBookId(int $bookId)
    {
        $book = static::findOne($bookId);

        if (!$book) {
            throw new Exception('Book not found');
        }

        return $book;
    }

    public static function findByBookNickname(string $nickname){
        return static::find()
            ->where(['nickName' => $nickname])
            ->one();
    }
}
