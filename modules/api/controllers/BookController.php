<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\params\BookAddParams;
use app\modules\api\controllers\params\BookListParams;
use app\modules\api\controllers\params\BookUpdateParams;
use app\modules\api\models\Book;
use app\modules\api\service\BookService;
use Yii;

class BookController extends RestController
{
    public function actionList() {
        $request = Yii::$app->request->get();
        $params = new BookListParams($request);

        $books = (new BookService())->getAllBooksWithJournal($params->nick_name, $params->issue_date, $params->return_date, $params->page_number, $params->page_size);
        // @TODO нужно возвращать состояние пагинации
        return $books;
    }

    public function actionBook($id)
    {
        $book = (new BookService())->getBookWithJournalById($id);
        return $book;
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
        $book = Book::findByBookId($id);
        $book->delete();
    }
}
