<?php

use yii\db\Migration;

/**
 * Class m230802_033949_insert_lang_table
 */
class m230802_033949_insert_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('lang', [
            'code' => 'en',
            'name' => 'English',
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
        echo "m230802_033949_insert_lang_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230802_033949_insert_lang_table cannot be reverted.\n";

        return false;
    }
    */
}
