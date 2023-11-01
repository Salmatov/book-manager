<?php

namespace app\modules\api\controllers\params;

use yii\base\Model;

class ReturnBookParams extends Model
{
    public int $userId;
    public int $bookId;

    public function __construct(array $params){
        $this->userId = $params['userId'];
        $this->bookId = $params['bookId'];

        $this->validate();
    }

    public function rules(): array
    {
        return [
            [['userId', 'bookId'], 'required'],
            [['userId', 'bookId'], 'number'],
        ];
    }
}
