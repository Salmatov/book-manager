<?php

namespace app\modules\api\params;
use DateTime;
use yii\base\Model;

class UserAddParams extends Model
{
    public string $firstName;
    public string $lastName;
    public DateTime $registrationDate;

    public function __construct(array $params)
    {

        $this->firstName = $params['firstName'];
        $this->lastName = $params['lastName'];
        $this->registrationDate = new DateTime();
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName', 'registrationDate'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
        ];
    }
}


