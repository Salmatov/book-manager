<?php

namespace app\modules\api\controllers;

use app\modules\api\params\BookUpdateParams;
use app\modules\api\service\BookService;
use Yii;
use app\modules\api\models\Book;
use app\modules\api\params\BookAddParams;

class BookController extends RestController
{

    public function actionAdd()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $bookAddParams = new BookAddParams($request);
        $bookService = new BookService();

        try {
            $bookService->validate($bookAddParams);
            BookService::findDublicate($bookAddParams->nickName);
            $book = new Book();
            $book = BookService::bookLoader($book, $bookAddParams);
            $massage = BookService::saveBook($book);
            Yii::$app->response->setStatusCode(201);
            return $massage;

        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['errors' => $e->getMessage()];
        }
    }

    public function actionUpdate($id)
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $bookUpdateParams = new BookUpdateParams($request);
        $bookService = new BookService();

        try {
            $bookService->validate($bookUpdateParams);
            $book = BookService::findByBookId($id);
            $book = BookService::bookLoader($book, $bookUpdateParams);
            $massage = BookService::saveBook($book);
            Yii::$app->response->setStatusCode(201);
            return $massage;
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['errors' => $e->getMessage()];
        }
    }
}

