<?php

namespace app\modules\api\service;

use app\modules\api\models\Book;
use app\modules\api\models\LibraryLog;
use Exception;

class LogService
{
    /**
     * @throws Exception
     */
    public function validate($params): void
    {
        if (!$params->validate()) {
            $errors = implode(', ', $params->getErrors());
            throw new Exception($errors,);
        }
    }

    public static function logLoader(LibraryLog $log, $params){
        if ($params->userId) {
            $log->userId = $params->userId;
        }
        if ($params->bookId) {
            $log->bookId = $params->bookId;
        }
        if ($params->issueDate) {
            $log->issueDate = $params->issueDate->format('Y-m-d');
        }
        if ($params->estimatedReturnDate) {
            $log->estimatedReturnDate = $params->estimatedReturnDate->format('Y-m-d');
        }
        return $log;

    }

    public static function saveLog(LibraryLog $log){
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
    public static function findBylogId($logId):?LibraryLog {
        $log = LibraryLog::findByLogId($logId);
        if (!$log) {
            throw new Exception('Log not found', 404);
        }
        return $log;
    }

    public static function registerReturnBook($log){
        $date = new \DateTime;
        $log->returnDate = $date->format('Y-m-d');
    }

}