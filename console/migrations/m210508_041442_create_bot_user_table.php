<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_user}}`.
 */
class m210508_041442_create_bot_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_user}}', [

            'id' => $this->primaryKey(),
            'user_id' => $this->string(),
            'fio' => $this->string(),
            'phone' => $this->string(),
            'step' => $this->string(),
            'temp_kurs_id' => $this->integer()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_user}}');
    }
}
