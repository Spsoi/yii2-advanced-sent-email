<?php

use yii\db\Migration;

/**
 * Class m230802_034031_insert_app_template_table
 */
class m230802_034031_insert_app_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $appId = $this->db->createCommand("SELECT id FROM mailer WHERE name = 'default'")->queryScalar();
        $templateId = $this->db->createCommand("SELECT id FROM lang WHERE code = 'en'")->queryScalar();

        $this->batchInsert('app_template', ['app_id', 'template_id', 'created_at', 'updated_at', 'deleted_at'], [
            [$appId, $templateId, date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', time()), null],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230802_034031_insert_app_template_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230802_034031_insert_app_template_table cannot be reverted.\n";

        return false;
    }
    */
}
