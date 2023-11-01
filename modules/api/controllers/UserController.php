<?php

namespace app\modules\api\controllers;

use app\modules\api\models\User;
use app\modules\api\params\UserAddParams;
use app\modules\api\params\UserUpdateParams;
use app\modules\api\service\UserService;
use Yii;

class UserController extends RestController
{

    public function actionTest() {
        return 'test';
    }


    public function actionAdd() {

        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $userParams = new UserAddParams($request);
        $userService = new UserService();

        try {
            $userService->validate($userParams);
            $user = new User();
            $user = UserService::userLoader($user, $userParams);
            $massage = $userService->saveUser($user);
            Yii::$app->response->setStatusCode(201);
            return $massage;
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['errors' => $e->getMessage()];
        }


    }

    public function actionUpdate($id) {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $userParams = new UserUpdateParams($request);
        $userService = new UserService();

        try {
            $userService->validate($userParams);
            $user = UserService::findByUserId($id);
            $user = UserService::userLoader($user, $userParams);
            $massage = $userService->saveUser($user);
            Yii::$app->response->setStatusCode(201);
            return $massage;

        }
        catch (\Exception $e) {

        }

        if (!$userParams->validate()) {
            Yii::$app->response->setStatusCode(422);
            return $userParams->errors;
        }

        $user = User::findByUserId($id);
        $user->firstName = $userParams->firstName;
        $user->lastName = $userParams->lastName;
        if ($user->save()) {
            Yii::$app->response->setStatusCode(201);
            return ['message' => 'User updated successfully'];
        } else {
            Yii::$app->response->setStatusCode(422);
            return ['errors' => $user->getErrors()];
        }

    }

    public function actionReader(int $id) {
        $user = User::findByUserId($id);
        if(!$user) {
            Yii::$app->response->setStatusCode(404);
            return ['message' => 'User not found'];
        }
        return $user;
    }

    public function actionList() {
        $request = Yii::$app->request->get();
        return $request['user_name'];
        $array = User::findX($request);
        return $request;

    }


    public function actionDelete($id) {
        $user = User::findByUserId($id);
        $user->delete();
    }
}