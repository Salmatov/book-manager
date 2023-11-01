<?php

use yii\db\Migration;

/**
 * Class m231101_190202_create_table_book
 */
class m231101_190202_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'author' => $this->string()->notNull(),
            'bookName' => $this->string()->notNull(),
            'nickName' => $this->string()->unique()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('book');
        return true;
    }
}
