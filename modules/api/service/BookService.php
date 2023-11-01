<?php

namespace app\modules\api\service;

use app\modules\api\models\Book;
use Exception;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 *
 */
class BookService
{
    /**
     * @throws Exception
     */
    public function findById(int $bookId): Book {
        /** @var Book $book */
        $book = Book::findById($bookId);
        if (!$book) {
            throw new NotFoundHttpException('Book not found');
        }
        return $book;
    }

    public function createBook(string $author, string $bookName, string $nickName): Book
    {
        $book = new Book();
        $book->author = $author;
        $book->bookName = $bookName;
        $book->nickName = $nickName;

        if (!$book->save()) {
            throw new BadRequestHttpException(join(', ', $book->getErrorSummary(true)));
        }

        return $book;
    }

    public function getBookWithJournalById(int $bookId)
    {
        return $this->findById($bookId);
    }

    public function updateBook(int $bookId, string $author, string $bookName, string $nickName): Book
    {
        $book = $this->findById($bookId);

        $book->author = $author;
        $book->bookName = $bookName;
        $book->nickName = $nickName;

        if (!$book->save()) {
            throw new BadRequestHttpException(join(', ', $book->getErrorSummary(true)));
        }

        return $book;
    }

    public function getAllBooksWithJournalQuery(?string $nick_name, ?string $issue_date, ?string $return_date)
    {
        $query = Book::find()->with('logs');

        if ($nick_name) {
            $query->orWhere(['like', 'nickName', $nick_name]);
        }
        if ($issue_date) {
            $query->joinWith(['logs' => function ($query) use ($issue_date) {
                $query->andWhere(['issueDate' => $issue_date]);
            }]);
        }

        if ($return_date) {
            $query->joinWith(['logs' => function ($query) use ($return_date) {
                $query->andWhere(['returnDate' => $return_date]);
            }]);
        }

        return $query;
    }
}