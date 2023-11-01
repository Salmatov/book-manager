<?php

namespace app\modules\api\controllers\params;

use yii\base\Model;
use yii\web\BadRequestHttpException;

class BookUpdateParams extends Model
{
    public string $author;
    public string $bookName;
    public string $nickName;

    public function __construct(array $params)
    {
        $this->author = $params['author'];
        $this->bookName = $params['bookName'];
        $this->nickName = $params['nickName'];

        if (!$this->validate()) {
            throw new BadRequestHttpException(join(' ', $this->getErrorSummary(true)));
        }
    }

    public function rules()
    {
        return [
            [['author', 'bookName', 'nickName'], 'required'],
            [['author', 'bookName', 'nickName'], 'string', 'max' => 255],

        ];
    }
}


