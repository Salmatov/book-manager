<?php

namespace app\modules\api\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{

    protected string $author;
    protected string $bookName;
    protected static $nickName;


    public static function tableName(){
        return 'book';
    }

}