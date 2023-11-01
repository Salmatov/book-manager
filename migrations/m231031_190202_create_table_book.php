<?php

use yii\db\Migration;

/**
 * Class m231031_190202_create_table_book
 */
class m231031_190202_create_table_book extends Migration
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

        // @TODO foreign keys
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231031_190202_create_table_book cannot be reverted.\n";
        $this->dropTable('book');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231031_190202_create_table_book cannot be reverted.\n";

        return false;
    }
    */
}
