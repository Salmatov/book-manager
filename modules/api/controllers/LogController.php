<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\params\LogAddParams;
use app\modules\api\controllers\params\LogListParams;
use app\modules\api\controllers\params\ReturnBookParams;
use app\modules\api\service\LogService;
use Yii;
use yii\data\ActiveDataProvider;

class LogController  extends RestController
{
    public function actionList()
    {
        $request = Yii::$app->request->get();
        $params = new LogListParams($request);

        $query = (new LogService())->getAllLogsWithReaderAndBookQuery($params->reader_name, $params->book_name);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSize' => $params->page_size,
                'page' => $params->page_number - 1,
            ],
        ]);
    }

    public function actionLog($id)
    {
        return (new LogService)->findById($id);
    }

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