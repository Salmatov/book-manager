<?php

namespace app\modules\api\service;

use app\modules\api\models\Book;
use app\modules\api\params\BookUpdateParams;
use Exception;

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
    public static function findByBookId(int $bookId):?Book {
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
}