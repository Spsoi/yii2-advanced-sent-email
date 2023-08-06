<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sent_emails}}`.
 */
class m230730_152504_create_sent_emails_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sent_emails}}', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer()->notNull(),
            'recipient_email' => $this->string()->notNull(),
            'recipient_name' => $this->string(),
            'sent_at' => $this->timestamp(),
            'delivered_at' => $this->timestamp(),
            'delivery_status' => 
                "ENUM(
                    'delivered', 
                    'failed', 
                    'pending'
                ) 
                NOT NULL DEFAULT 'pending'",
            'delivery_response' => $this->string(),
            'error_message' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->defaultValue(null),
        ]);

        $this->addForeignKey(
            'fk-sent_emails-template', 
            '{{%sent_emails}}', 
            'template_id', 
            '{{%template}}', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sent_emails}}');
    }
}