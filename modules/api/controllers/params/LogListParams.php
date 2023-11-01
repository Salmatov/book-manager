<?php

namespace app\modules\api\controllers\params;
use yii\base\Model;

class LogListParams extends Model
{
    public ?string $reader_name;
    public ?string $book_name;
    public ?int $page_size = null;
    public ?int $page_number = null;

    public function __construct(array $params)
    {
        $this->reader_name = $params['reader_name'] ?? null;
        $this->book_name = $params['book_name'] ?? null;
        $this->page_size = $params['page_size'] ?? null;
        $this->page_number = $params['page_number'] ?? null;
    }
}


