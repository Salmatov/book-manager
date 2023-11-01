<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\params\BookAddParams;
use app\modules\api\controllers\params\BookListParams;
use app\modules\api\controllers\params\BookUpdateParams;
use app\modules\api\service\BookService;
use Yii;
use yii\data\ActiveDataProvider;

class BookController extends RestController
{
    public function actionList() {
        $request = Yii::$app->request->get();
        $params = new BookListParams($request);

        $query = (new BookService())->getAllBooksWithJournalQuery($params->nick_name, $params->issue_date, $params->return_date);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSize' => $params->page_size,
                'page' => $params->page_number - 1,
            ],
        ]);
    }

    public function actionBook($id)
    {
        return (new BookService())->getBookWithJournalById($id);
    }

    public function actionAdd()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $params = new BookAddParams($request);

        $book = (new BookService())->createBook($params->author, $params->bookName, $params->nickName);

        return $book;
    }

    public function actionUpdate($id)
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $params = new BookUpdateParams($request);

        $book = (new BookService())->updateBook($id, $params->author, $params->bookName, $params->nickName);

        return $book;
    }

    public function actionDelete($id)
    {
        $book = (new BookService())->findById($id);
        $book->delete();
    }
}
