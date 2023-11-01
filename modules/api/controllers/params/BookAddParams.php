<?php

namespace app\modules\api\controllers\params;

use yii\base\Model;

class BookAddParams extends Model

{
    public string $author;
    public string $bookName;
    public string $nickName;

    public function __construct(array $params)
    {
        $this->author = $params['author'];
        $this->bookName = $params['bookName'];
        $this->nickName = $params['nickName'];

        // @TODO проверить все валидации на выдачу Exception
        $this->validate();
    }

    public function rules()
    {
        return [
            [['author', 'bookName', 'nickName'], 'required'],
            [['author', 'bookName', 'nickName'], 'string', 'max' => 255],

        ];
    }
}


