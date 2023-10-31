<?php

namespace app\modules\api\controllers;

use app\modules\api\models\User;
use app\modules\api\params\UserAddParams;
use app\modules\api\params\UserUpdateParams;
use Yii;

class UserController extends RestController
{

    public function actionTest() {
        return 'test';
    }


    public function actionAdd() {

        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $userDto = new UserAddParams();
        $userDto->setAttributes($request);

        if (!$userDto->validate()) {
            return $userDto->errors;
        }

        $user = new User();
        $user->firstName = $userDto->firstName;
        $user->lastName = $userDto->lastName;
        //$user->birthDate = new \DateTime();
        //$user->registrationDate = new \DateTime();
        $user->save();

    }

    public function actionUpdate($id) {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $userDto = new UserUpdateParams();
        $userDto->setAttributes($request);

        if (!$userDto->validate()) {
            return $userDto->errors;
        }
        $user = User::findByUserId($id);
        $user->firstName = $userDto->firstName;
        $user->lastName = $userDto->lastName;
        //$user->birthDate = new \DateTime();
        $user->save();
        return $user;

    }

}