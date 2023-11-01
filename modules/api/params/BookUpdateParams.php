<?php

namespace app\modules\api\params;

use yii\base\Model;

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
    }

    public function rules()
    {
        return [
            [['author', 'bookName', 'nickName'], 'string', 'max' => 255],

        ];
    }
}


