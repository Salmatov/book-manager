<?php

use yii\db\Migration;

/**
 * Class m231101_190324_create_table_libraryLog
 */
class m231101_190324_create_table_libraryLog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('libraryLog', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'bookId' => $this->integer()->notNull(),
            'issueDate' => $this->date()->notNull(),
            'estimatedReturnDate' => $this->date()->notNull(),
            'returnDate' => $this->date()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('libraryLog');
        return true;
    }
}
