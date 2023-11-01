<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\params\UserAddParams;
use app\modules\api\controllers\params\UserListParams;
use app\modules\api\controllers\params\UserUpdateParams;
use app\modules\api\service\UserService;
use Yii;
use yii\data\ActiveDataProvider;

class UserController extends RestController
{
    public function actionAdd() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $params = new UserAddParams($request);

        $user = (new UserService())->addUser($params->firstName, $params->lastName);

        Yii::$app->response->setStatusCode(201);
        return $user;
    }

    public function actionUpdate($id) {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $params = new UserUpdateParams($request);

        $user = (new UserService())->updateUser($id, $params->firstName, $params->lastName);

        Yii::$app->response->setStatusCode(200);
        return $user;
    }

    public function actionReader(int $id) {
        return (new UserService())->getUserWithJournalById($id);
    }

    public function actionList() {
        $request = Yii::$app->request->get();
        $params = new UserListParams($request);

        $query = (new UserService())->getAllUsersWithJournalQuery($params->user_name, $params->return_date);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSize' => $params->page_size,
                'page' => $params->page_number - 1,
            ],
        ]);
    }

    public function actionDelete($id) {
        $user = (new UserService)->findById($id);
        $user->delete();
    }
}