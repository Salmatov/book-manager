<?php

namespace app\modules\api\models;

use DateTime;
use Exception;
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

    public static function findByLogId(int $logId){
        return static::find()
            ->where(['Id' => $logId])
            ->one();
    }

    /**
     * @param int $userId
     * @param int $bookId
     * @return array|ActiveRecord
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