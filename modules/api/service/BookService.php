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
    /**
     * @throws Exception
     */
    public function findById(int $bookId): Book {
        /** @var Book $book */
        $book = Book::findById($bookId);
        if (!$book) {
            throw new Exception('Book not found', 404);
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
            throw new Exception(join(', ', $book->getErrorSummary(true)));
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
            throw new Exception(join(', ', $book->getErrorSummary(true)));
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