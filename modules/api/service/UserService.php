<?php

namespace app\modules\api\service;

use app\modules\api\models\User;
use DateTime;
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
    public static function findByUserId($id): ?User
    {
        /** @var User $user */
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

    ############

    /**
     * @param string $firstName
     * @param string $lastName
     * @return User
     * @throws Exception
     */
    public function addUser(string $firstName, string $lastName): User
    {
        $user = new User();
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->registrationDate = (new DateTime())->format('Y-m-d H:i:s');

        if (!$user->save()) {
            throw new Exception(join(', ', $user->getErrorSummary(true)));
        }

        return $user;
    }

    /**
     * @param int $userId
     * @param string $firstName
     * @param string $lastName
     * @return User
     * @throws Exception
     */
    public function updateUser(int $userId, string $firstName, string $lastName): User
    {
        $user = User::findByUserId($userId);

        $user->firstName = $firstName;
        $user->lastName = $lastName;

        if (!$user->save()) {
            throw new Exception(join(', ', $user->getErrorSummary(true)));
        }

        return $user;
    }

    public function getUserWithJournalById(int $id)
    {
        $user = User::findByUserId($id);
        // @TODO добавить связь journals
        //User::find()->joinWith('');
        return $user;
    }

    public function getAllUsersWithJournal(?string $user_name, ?string $return_date, ?int $page_number, ?int $page_size)
    {
        $query = User::find();
        if ($user_name) {
            $query->orWhere(['like', 'firstName', $user_name]);
            $query->orWhere(['like', 'lastName', $user_name]);
        }
        // @TODO добавить связь journals
        /*if ($returnDate = \Yii::$app->request->get('return_date')) {
            $query->joinWith(['journals' => function ($query) use ($returnDate) {
                $query->andWhere(['journal.return_date' => $returnDate]);
            }]);
        }*/

        $query->limit = $page_size ?? 10;

        if ($page_number) {
            $query->offset = ($page_number - 1) * $query->limit;
        }

        return $query->all();
    }
}
