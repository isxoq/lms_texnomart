<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_user_action}}`.
 */
class m210508_043441_create_bot_user_action_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_user_action}}', [
            'id' => $this->primaryKey(),
            'bot_user_id' => $this->integer(),
            'kurs_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_user_action}}');
    }
}
