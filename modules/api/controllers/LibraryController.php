<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\params\LogAddParams;
use app\modules\api\controllers\params\ReturnBookParams;
use app\modules\api\service\LogService;
use Yii;

class LibraryController  extends RestController
{
    public function actionAdd()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $params = new LogAddParams($request);

        $libraryLog = (new LogService())->createRecord($params->userId, $params->bookId, $params->estimatedReturnDate);

        Yii::$app->response->setStatusCode(201);
        //return $libraryLog
    }

    public function actionUpdate()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $params = new ReturnBookParams($request);

        $log = (new LogService())->registerReturnBook($params->userId, $params->bookId);

        Yii::$app->response->setStatusCode(200);
        //return $log;
    }
}