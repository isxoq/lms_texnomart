<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_history}}`.
 */
class m210430_035312_create_user_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_history}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer(),
            'url' => $this->text(),
            'prev_url' => $this->text(),
            'page_title' => $this->text(),
            'date' => $this->integer(),
            'ip' => $this->string(50),
            'device' => $this->text(),
            'device_type' => $this->tinyInteger(),
        ]);

        $this->addForeignKey('fk_user_history_user_id', 'user_history', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_history_user_id', 'user_history');
        $this->dropTable('{{%user_history}}');
    }
}
