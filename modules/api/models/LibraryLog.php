<?php

namespace app\modules\api\models;

use yii\db\ActiveRecord;

class LibraryLog extends ActiveRecord
{
    protected string $userId;
    protected string $bookId;
    protected \DateTime $issueDate;
    protected \DateTime $estimatedReturnDate;
    protected \DateTime $returnDate;


    public static function tableName(){
        return 'library_log';
    }

}