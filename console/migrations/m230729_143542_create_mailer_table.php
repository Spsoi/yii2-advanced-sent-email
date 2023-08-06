<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mailer}}`.
 */
class m230729_143542_create_mailer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%mailer}}', [
            'id' => $this->primaryKey(),
            'scheme' => $this->string()->notNull(),
            'dsn' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'host' => $this->string()->notNull(),
            'port' => $this->integer()->notNull(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'encryption' => $this->string(), // tls или ssl
            'is_active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->defaultValue(null),
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mailer}}');
    }
}
