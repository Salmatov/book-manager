<?php

namespace app\modules\api\service;

use app\modules\api\models\LibraryLog;
use DateTime;
use Exception;
use yii\db\ActiveQuery;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class LogService
{
    /**
     * @throws Exception
     */
    public static function findById(int $logId): LibraryLog {
        /** @var LibraryLog $log */
        $log = LibraryLog::findById($logId);
        if (!$log) {
            throw new NotFoundHttpException('Log not found', 404);
        }
        return $log;
    }

    public function createRecord(int $userId, int $bookId, DateTime $estimatedReturnDate): LibraryLog
    {
        $user = (new UserService)->findById($userId);
        $book = (new BookService)->findById($bookId);

        $log = new LibraryLog();
        $log->userId = $user->id;
        $log->bookId = $book->id;
        $log->issueDate = (new DateTime())->format('Y-m-d');
        $log->estimatedReturnDate = $estimatedReturnDate->format('Y-m-d 00:00:00');

        if (!$log->save()) {
            throw new BadRequestHttpException(join('. ', $log->getErrorSummary(true)));
        }

        return $log;
    }

    /**
     * @param int $userId
     * @param int $bookId
     * @return LibraryLog
     * @throws Exception
     */
    public function registerReturnBook(int $userId, int $bookId): LibraryLog
    {
        $log = LibraryLog::findByUserIdAndBookId($userId, $bookId);

        if ($log->returnDate != null) {
            throw new BadRequestHttpException('Book is already returned');
        }

        $log->returnDate = new \DateTime;

        if (!$log->save()) {
            throw new BadRequestHttpException(join('. ', $log->getErrorSummary(true)));
        }

        return $log;
    }

    public function getAllLogsWithReaderAndBookQuery(?string $reader_name, ?string $book_name)
    {
        $query = LibraryLog::find()->with(['user', 'book']);

        if ($reader_name) {
            $query->joinWith(['user' => function (ActiveQuery $query) use ($reader_name) {
                $query->orWhere(['like', 'firstName', $reader_name]);
                $query->orWhere(['like', 'lastName', $reader_name]);
            }]);
        }
        if ($book_name) {
            $query->joinWith(['book' => function (ActiveQuery $query) use ($book_name) {
                $query->andWhere(['like', 'bookName', $book_name]);
            }]);
        }

        return $query;
    }

}