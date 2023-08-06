<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%template}}`.
 */
class m230729_143625_create_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%template}}', [
            'id' => $this->primaryKey(),
            'mailer_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'subject' => $this->string(),
            'body' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->defaultValue(null),
        ]);

        // Mailer
        $this->addForeignKey(
            'fk-template-mailer',
            '{{%template}}',
            'mailer_id',
            '{{%mailer}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // "Lang"
        $this->addForeignKey(
            'fk-template-lang',
            '{{%template}}',
            'lang_id',
            '{{%lang}}',
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
        $this->dropTable('{{%template}}');
    }
}
