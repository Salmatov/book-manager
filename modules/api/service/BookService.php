<?php

namespace app\modules\api\service;

use app\modules\api\models\Book;
use app\modules\api\models\User;
use Exception;

/**
 *
 */
class BookService
{
    public static function bookLoader(Book $book, $params): Book{
        if ($params->author) {
            $book->author = $params->author;
        }
        if ($params->bookName) {
            $book->bookName = $params->bookName;
        }
        if ($params->nickName) {
            $book->nickName = $params->nickName;
        }
        return $book;
    }

    /**
     * @throws Exception
     */
    public function validate($params): void
    {
        if (!$params->validate()) {
            $errors = implode(', ', $params->getErrors());
            throw new Exception($errors,);
        }
    }

    /**
     * @throws Exception
     */
    public static function findByBookId(int $bookId): Book {
        /** @var Book $book */
        $book = Book::findByBookId($bookId);
        if (!$book) {
            throw new Exception('Book not found', 404);
        }
        return $book;
    }

    /**
     * @throws Exception
     */
    public static function saveBook(Book $book){
        if ($book->save()) {
            return ['message' => 'User created successfully'];
        } else {
            $errors = implode(', ', $book->getErrors());
            throw new Exception($errors,);
        }
    }

    public static function findDublicate($nickname): void
    {
        $book = Book::findByBookNickname($nickname);
        if ($book) {
            throw new Exception('Book already exists', 409);
        }

    }

    ##############################################################

    public function createBook(string $author, string $bookName, string $nickName): Book
    {
        $book = new Book();
        $book->author = $author;
        $book->bookName = $bookName;
        $book->nickName = $nickName;

        if (!$book->save()) {
            throw new Exception(join(', ', $book->getErrorSummary(true)));
        }

        return $book;
    }

    public function getBookWithJournalById(int $bookId)
    {
        $book = Book::findByBookId($bookId);
        // @TODO добавить связь journals
        //Book::find()->joinWith('');
        return $book;
    }

    public function updateBook(int $bookId, string $author, string $bookName, string $nickName): Book
    {
        $book = Book::findByBookId($bookId);

        $book->author = $author;
        $book->bookName = $bookName;
        $book->nickName = $nickName;

        if (!$book->save()) {
            throw new Exception(join(', ', $book->getErrorSummary(true)));
        }

        return $book;
    }

    public function getAllBooksWithJournal(?string $nick_name, ?string $issue_date, ?string $return_date, ?int $page_number, ?int $page_size)
    {
        $query = Book::find();
        if ($nick_name) {
            $query->orWhere(['like', 'nickName', $nick_name]);
        }
        if ($issue_date) {
            $query->orWhere(['=', 'issueDate', $issue_date]);
        }
        if ($return_date) {
            $query->orWhere(['=', 'returnDate', $return_date]);
        }
        // @TODO добавить связь journals
        /*if ($returnDate = \Yii::$app->request->get('return_date')) {
            $query->joinWith(['journals' => function ($query) use ($returnDate) {
                $query->andWhere(['journal.return_date' => $returnDate]);
            }]);
        }*/

        $query->limit = $page_size ?? 10;

        if ($page_number) {
            $query->offset = ($page_number - 1) * $query->limit;
        }

        return $query->all();
    }
}