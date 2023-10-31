<?php

namespace app\modules\api\controllers;


use yii\helpers\ArrayHelper;

class RestController extends \yii\rest\Controller
{
    public function behaviors()

    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ]);
    }

}