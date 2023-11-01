<?php

namespace app\modules\api\controllers\params;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class UserAddParams extends Model
{
    public ?string $firstName;
    public ?string $lastName;

    public function __construct(array $params)
    {
        $this->firstName = $params['firstName'] ?? null;
        $this->lastName = $params['lastName'] ?? null;

        if (!$this->validate()) {
            throw new BadRequestHttpException(join(' ', $this->getErrorSummary(true)));
        }
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
        ];
    }
}


