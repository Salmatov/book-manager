<?php

namespace app\modules\api\params;

use yii\base\Model;

class UserAddParams extends Model
{

    public function __construct(
        public string $firstName = '',
        public string $lastName = '',
        //public ?\DateTime $birthDate = null,
        //public ?\DateTime $registrationDate = null

    ){}

    public function rules()
    {
        return [
            [['firstName', 'lastName', /*'birthDate', 'registrationDate'*/], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 255,'min' => 3],
            //[['birthDate', 'registrationDate'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

}