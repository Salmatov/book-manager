<?php

namespace app\modules\api\models;

use yii\db\ActiveQuery;
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

    public function getLogs(): ActiveQuery
    {
        return $this->hasMany(LibraryLog::class, ['bookId' => 'id']);
    }

    public static function findById(int $bookId): ?Book
    {
        return static::findOne($bookId);
    }
}
