<?php

namespace app\modules\api\service;

use app\modules\api\models\User;
use DateTime;
use Exception;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class UserService
{
    public function getUser(){}

    /**
     * @throws Exception
     */
    public function findById($id): ?User
    {
        $user = User::findById($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found', 404);
        }
        return $user;
    }

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
            throw new BadRequestHttpException(join(', ', $user->getErrorSummary(true)));
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
        $user = $this->findById($userId);

        $user->firstName = $firstName;
        $user->lastName = $lastName;

        if (!$user->save()) {
            throw new BadRequestHttpException(join(', ', $user->getErrorSummary(true)));
        }

        return $user;
    }

    public function getUserWithJournalById(int $id)
    {
        $user = User::find()->with('logs')->where(['id' => $id])->one();
        if ($user == null) {
            throw new BadRequestHttpException('User not found');
        }
        return $user;
    }

    public function getAllUsersWithJournalQuery(?string $user_name, ?string $return_date)
    {
        $query = User::find()->with('logs');

        if ($user_name) {
            $query->orWhere(['like', 'firstName', $user_name]);
            $query->orWhere(['like', 'lastName', $user_name]);
        }
        if ($return_date) {
            $query->with(['logs' => function ($query) use ($return_date) {
                $query->andWhere(['returnDate' => $return_date]);
            }]);
        }

        return $query;
    }
}
