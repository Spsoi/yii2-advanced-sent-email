<?php

use yii\db\Migration;

class m230729_143445_create_app_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->createTable('{{%app}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
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
        $this->dropTable('{{%app}}');
    }
}