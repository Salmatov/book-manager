<?php

namespace app\modules\api\params;

use yii\base\Model;

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
    }

    public function rules(){
        return [
            [['userId', 'bookId', 'issueDate', 'estimatedReturnDate'], 'required'],

        ];
    }
}
