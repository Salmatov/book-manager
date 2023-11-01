<?php

namespace app\modules\api\controllers\params;
use yii\base\Model;

class BookListParams extends Model
{
    public ?string $nick_name;
    public ?string $issue_date;
    public ?string $return_date;
    public ?int $page_size = null;
    public ?int $page_number = null;

    public function __construct(array $params)
    {
        $this->nick_name = $params['nick_name'] ?? null;
        $this->issue_date = $params['issue_date'] ?? null;
        $this->return_date = $params['return_date'] ?? null;
        $this->page_size = $params['page_size'] ?? null;
        $this->page_number = $params['page_number'] ?? null;
    }
}


