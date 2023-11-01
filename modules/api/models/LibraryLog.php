<?php

namespace app\modules\api\models;

use DateTime;
use Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $userId
 * @property int $bookId
 * @property DateTime $issueDate
 * @property DateTime $estimatedReturnDate
 * @property DateTime $returnDate
 */
class LibraryLog extends ActiveRecord
{

    public static function tableName(){
        return 'libraryLog';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'bookId']);
    }

    public static function findById(int $logId): ?LibraryLog
    {
        return static::findOne($logId);
    }

    /**
     * @param int $userId
     * @param int $bookId
     * @return LibraryLog
     * @throws Exception
     */
    public static function findByUserIdAndBookId(int $userId, int $bookId): LibraryLog
    {
        /** @var LibraryLog $log */
        $log = static::find()
            ->where(['userId' => $userId])
            ->andWhere(['bookId' => $bookId])
            ->one();
        if (!$log) {
            throw new Exception('Log not found');
        }
        return $log;
    }

}