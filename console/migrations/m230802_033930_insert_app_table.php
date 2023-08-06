<?php

use yii\db\Migration;

/**
 * Class m230802_033930_insert_app_table
 */
class m230802_033930_insert_app_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('app', [
            'name' => 'My App',
            'description' => 'This is my application',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
            'deleted_at' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230802_033930_insert_app_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230802_033930_insert_app_table cannot be reverted.\n";

        return false;
    }
    */
}
