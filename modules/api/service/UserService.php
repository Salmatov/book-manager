<?php

namespace app\modules\api\service;

use app\modules\api\models\User;
use Exception;

class UserService
{
    public function getUser(){}


    public static function userLoader($user, $params){
        if ($params->firstName) {
            $user->firstName = $params->firstName;
        }
        if ($params->lastName) {
            $user->lastName = $params->lastName;
        }
        if ($params->registrationDate) {
            $user->registrationDate = $params->registrationDate->format('Y-m-d');
        }
        return $user;

    }
    public function validate($params){
        if (!$params->validate()) {
            $errors = implode(', ', $params->getErrors());
            throw new Exception($errors,);
        }
        return $params;
    }

    public function saveUser($params){
        if ($params->save()) {
            return ['message' => 'User created successfully'];
        } else {
            $errors = implode(', ', $params->getErrors());
            throw new Exception($errors,);
        }
    }

    /**
     * @throws Exception
     */
    public static function findByUserId($id)
    {
        $user = User::findByUserId($id);
        if (!$user) {
            throw new Exception('User not found', 404);
        }
        return $user;

    }


    public static function getUserListByNameAndReturnDate($params){
        $query = User::getUserListByNameAndReturnDate(
            $params['user_name'],
            $params['return_date'],
            $params['page_number'],
            $params['page_size']
        );
    }
}
