<?php

namespace app\modules\api\controllers\params;

use yii\base\Model;
use yii\web\BadRequestHttpException;

class LogAddParams extends Model

{
    public int $userId;
    public int $bookId;
    public \DateTime $issueDate;
    public \DateTime $estimatedReturnDate;

    public function __construct(array $params){
        $this->userId = $params['userId'];
        $this->bookId = $params['bookId'];
        $this->issueDate = new \DateTime();
        $this->estimatedReturnDate = new \DateTime($params['estimatedReturnDate']);

        if (!$this->validate()) {
            throw new BadRequestHttpException(join(' ', $this->getErrorSummary(true)));
        }
    }

    public function rules(): array
    {
        return [
            [['userId', 'bookId', 'issueDate', 'estimatedReturnDate'], 'required'],
        ];
    }
}
