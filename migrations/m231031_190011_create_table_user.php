<?php

use yii\db\Migration;

/**
 * Class m231031_190011_create_table_user
 */
class m231031_190011_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'firstName' => $this->string()->notNull(),
            'lastName' => $this->string()->notNull(),
            'registrationDate' => $this->date()->notNull(),
        ]);

        // @TODO foreign keys
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231031_190011_create_table_user cannot be reverted.\n";
        $this->dropTable('user');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231031_190011_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
