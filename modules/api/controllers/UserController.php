<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\params\UserAddParams;
use app\modules\api\controllers\params\UserListParams;
use app\modules\api\controllers\params\UserUpdateParams;
use app\modules\api\models\User;
use app\modules\api\service\UserService;
use Yii;

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
        $user = (new UserService())->getUserWithJournalById($id);
        return $user;
    }

    public function actionList() {
        $request = Yii::$app->request->get();
        $params = new UserListParams($request);

        $user = (new UserService())->getAllUsersWithJournal($params->user_name, $params->return_date, $params->page_number, $params->page_size);

        return $user;
    }

    public function actionDelete($id) {
        $user = User::findByUserId($id);
        $user->delete();
    }
}