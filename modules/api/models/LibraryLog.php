<?php

namespace app\modules\api\models;

use yii\db\ActiveRecord;

class LibraryLog extends ActiveRecord
{

    public static function tableName(){
        return 'libraryLog';
    }

    public static function findByLogId(int $logId){
        return static::find()
            ->where(['Id' => $logId])
            ->one();
    }

}