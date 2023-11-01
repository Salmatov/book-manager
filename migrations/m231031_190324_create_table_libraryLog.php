<?php

use yii\db\Migration;

/**
 * Class m231031_190324_create_table_libraryLog
 */
class m231031_190324_create_table_libraryLog extends Migration
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
        echo "m231031_190324_create_table_libraryLog cannot be reverted.\n";
        $this->dropTable('libraryLog');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231031_190324_create_table_libraryLog cannot be reverted.\n";

        return false;
    }
    */
}
