<?php

use yii\db\Migration;

/**
 * Class m230802_033840_insert_mailer_table
 */
class m230802_033840_insert_mailer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('mailer', [
            'scheme' => 'smtp',
            'dsn' => 'smtp://username:password@host:port?encryption=tls',
            'name' => 'default',
            'host' => 'smtp.example.com',
            'port' => 587,
            'username' => 'your-username',
            'password' => 'your-password',
            'encryption' => 'tls',
            'is_active' => true,
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
        echo "m230802_033840_insert_mailer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230802_033840_insert_mailer_table cannot be reverted.\n";

        return false;
    }
    */
}
