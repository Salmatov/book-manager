<?php

namespace app\modules\api\controllers\params;
use yii\base\Model;

class UserAddParams extends Model
{
    public string $firstName;
    public string $lastName;

    public function __construct(array $params)
    {
        $this->firstName = $params['firstName'];
        $this->lastName = $params['lastName'];

        $this->validate();
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
        ];
    }
}


