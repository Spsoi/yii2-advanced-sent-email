<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%app_template}}`.
 */
class m230730_093832_create_app_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%app_template}}', [
            'app_id' => $this->integer()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'PRIMARY KEY(app_id, template_id)'
        ]);

        $this->addForeignKey(
            'fk-app_template-app',
            '{{%app_template}}',
            'app_id',
            '{{%app}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-app_template-template',
            '{{%app_template}}',
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
        $this->dropTable('{{%app_template}}');
    }
}
