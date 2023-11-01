<?php

namespace app\modules\api\controllers\params;
use yii\base\Model;

class UserListParams extends Model
{
    public ?string $user_name;
    public ?string $return_date;
    public ?int $page_size = null;
    public ?int $page_number = null;

    public function __construct(array $params)
    {
        $this->user_name = $params['user_name'] ?? null;
        $this->return_date = $params['return_date'] ?? null;
        $this->page_size = $params['page_size'] ?? null;
        $this->page_number = $params['page_number'] ?? null;
    }
}


