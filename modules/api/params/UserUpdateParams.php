<?php

namespace app\modules\api\params;

use yii\base\Model;

class UserUpdateParams extends Model
{
    public function __construct(
        public string $firstName = '',
        public string $lastName = '',
        //public ?\DateTime $birthDate = null,

    ){}

    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'required', 'when' => function ($model) {
                return empty($model->firstName) && empty($model->lastName);
            }],
            [['firstName', 'lastName'], 'string', 'max' => 255,'min' => 3],
            //[['birthDate'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

}