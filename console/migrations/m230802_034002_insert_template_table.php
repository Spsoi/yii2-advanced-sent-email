<?php

use yii\db\Migration;

/**
 * Class m230802_034002_insert_template_table
 */
class m230802_034002_insert_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $mailerId = $this->db->createCommand("SELECT id FROM mailer WHERE name = 'default'")->queryScalar();
        $langId = $this->db->createCommand("SELECT id FROM lang WHERE code = 'en'")->queryScalar();

        $this->batchInsert('template', 
            ['mailer_id',   'lang_id', 'name', 'subject', 'body', 'created_at', 'updated_at', 'deleted_at'], [
            [$mailerId,     $langId, 'registration_email', 'Welcome to My App!', 'Dear {username}, Welcome to My App!', date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', time()), null],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230802_034002_insert_template_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230802_034002_insert_template_table cannot be reverted.\n";

        return false;
    }
    */
}
