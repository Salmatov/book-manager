<?php

namespace app\modules\api\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{


    public static function tableName()
    {
        return 'user';
    }

    public static function findByUserId($id){
        return static::find()
            ->where(['id' => $id])
            ->one();
    }

}