<?php

namespace app\modules\api\controllers;

use app\modules\api\models\LibraryLog;
use app\modules\api\params\LogAddParams;
use app\modules\api\service\LogService;
use Yii;

class LibraryController  extends RestController
{
    public function actionAdd()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $logAddParams = new LogAddParams($request);
        $logService = new LogService();

        try {
            $logService->validate($logAddParams);
            $log = new LibraryLog();
            $log = logService::logLoader($log, $logAddParams);
            $massage = LogService::saveLog($log);
            Yii::$app->response->setStatusCode(201);
            return $massage;
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['errors' => $e->getMessage()];
        }
    }

    public function actionUpdate($id){
        try {
            $log = LogService::findBylogId($id);
            LogService::registerReturnBook($log);
            $massage = LogService::saveLog($log);
            Yii::$app->response->setStatusCode(201);
            return $massage;
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['errors' => $e->getMessage()];
        }
    }
}