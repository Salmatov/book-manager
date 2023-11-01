<?php

namespace app\modules\api\service;

use app\modules\api\models\LibraryLog;
use DateTime;
use Exception;
use yii\web\BadRequestHttpException;

class LogService
{
    /**
     * @throws Exception
     */
    public function validate($params): void
    {
        if (!$params->validate()) {
            $errors = implode(', ', $params->getErrors());
            throw new Exception($errors);
        }
    }

    public static function logLoader(LibraryLog $log, $params): LibraryLog
    {
        $log->userId = $params->userId ?: $log->userId;
        $log->bookId = $params->bookId ?: $log->bookId;
        $log->issueDate = !empty($params->issueDate) ? $params->issueDate->format('Y-m-d') : $log->issueDate;
        $log->estimatedReturnDate = !empty($params->estimatedReturnDate) ? $params->estimatedReturnDate->format('Y-m-d') : $log->estimatedReturnDate;
        return $log;
    }

    public static function saveLog(LibraryLog $log)
    {
        if ($log->save()) {
            return ['message' => 'Log created successfully'];
        } else {
            $errors = implode(', ', $log->getErrors());
            throw new Exception($errors,);
        }
    }

    /**
     * @throws Exception
     */
    public static function findByLogId($logId): ?LibraryLog
    {
        /** @var LibraryLog|null $log */
        $log = LibraryLog::findByLogId($logId);
        if (!$log) {
            throw new Exception('Log not found', 404);
        }
        return $log;
    }

    ########################################################

    public function createRecord(int $userId, int $bookId, DateTime $estimatedReturnDate): LibraryLog
    {
        $user = UserService::findByUserId($userId);
        $book = BookService::findByBookId($bookId);

        $log = new LibraryLog();
        $log->userId = $user->id;
        $log->bookId = $book->id;
        $log->estimatedReturnDate = $estimatedReturnDate;

        if (!$log->save()) {
            throw new Exception(join('. ', $log->getErrorSummary(true)));
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
            throw new Exception('Book is already returned');
        }

        $log->returnDate = new \DateTime;

        if (!$log->save()) {
            throw new Exception(join('. ', $log->getErrorSummary(true)));
        }

        return $log;
    }

}