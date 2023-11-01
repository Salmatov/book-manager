<?php

namespace app\modules\api\controllers\params;

use yii\base\Model;
use yii\web\BadRequestHttpException;

class ReturnBookParams extends Model
{
    public int $userId;
    public int $bookId;

    public function __construct(array $params){
        $this->userId = $params['userId'];
        $this->bookId = $params['bookId'];

        if (!$this->validate()) {
            throw new BadRequestHttpException(join(' ', $this->getErrorSummary(true)));
        }
    }

    public function rules(): array
    {
        return [
            [['userId', 'bookId'], 'required'],
            [['userId', 'bookId'], 'number'],
        ];
    }
}
