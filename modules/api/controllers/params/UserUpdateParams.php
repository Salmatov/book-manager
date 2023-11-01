<?php

namespace app\modules\api\controllers\params;

use yii\base\Model;

class UserUpdateParams extends Model
{
    public string $firstName;
    public string $lastName;

    public function __construct(array $params)
    {
        $this->firstName = $params['firstName'];
        $this->lastName = $params['lastName'];
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
        ];
    }
}


